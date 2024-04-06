# https://b24-urn54f.bitrix24.eu/rest/9/6ygkctgbdqc8fyjk/ - rest api
# URL вебхука
import requests

# URL вебхука
webhook_url_contact_list = 'https://b24-urn54f.bitrix24.eu/rest/9/6ygkctgbdqc8fyjk/'
webhook_url_user_get = 'https://b24-urn54f.bitrix24.eu/rest/9/1li8dtn0u8x7jsz5/'
webhook_url_company_list = 'https://b24-urn54f.bitrix24.eu/rest/9/b1nacmjmg1liqolf/'
webhook_url_contact_update = 'https://b24-urn54f.bitrix24.eu/rest/9/240161vij4e2w56n/'
webhook_url_company_update = 'https://b24-urn54f.bitrix24.eu/rest/9/35i2laf8yig4dx5l/'
webhook_url_contact_add = 'https://b24-urn54f.bitrix24.eu/rest/9/fey5lmdeuhs5cjwd/'

# Получить список всех сотрудников с телефонами
def get_all_managers():
    url = f"{webhook_url_user_get}user.get.json"
    response = requests.post(url, json={'select': ["ID", "UF_PHONE_INNER"]})
    return response.json().get('result') if response.status_code == 200 else []

# Функция для поиска менеджера по внутреннему номеру телефона
def get_responsible_id(phone_number):
    managers = get_all_managers()
    for manager in managers:
        if phone_number in manager.get("UF_PHONE_INNER", ""):
            return manager["ID"]
    return None

# Функция для поиска сущностей по номеру телефона
def search_entities_company( phone_number):
    search_url = f"{webhook_url_company_list}crm.company.list"
    query = {
        'filter': {"PHONE": phone_number},
        'select': ["ID", "NAME", "PHONE"]
    }
    response = requests.post(search_url, json=query)
    return response.json().get('result') if response.status_code == 200 else []

def search_entities_contact( phone_number):
    search_url = f"{webhook_url_contact_list}crm.contact.list"
    query = {
        'filter': {"PHONE": phone_number},
        'select': ["ID", "NAME", "PHONE"]
    }
    response = requests.post(search_url, json=query)
    return response.json().get('result') if response.status_code == 200 else []


# Функция для добавления комментария к сущностям
def add_comment_to_entities_contact( entities, comment):
    for entity in entities:
        update_url = f"{webhook_url_company_update}crm.company.update"
        update_query = {
            'id': entity['ID'],
            'fields': {"COMMENTS": comment}
        }
        response = requests.post(update_url, json=update_query)
        if response.status_code != 200:
            print(f"Ошибка при добавлении комментария к  с ID {entity['ID']}")

def add_comment_to_entities_company( entities, comment):
    for entity in entities:
        update_url = f"{webhook_url_contact_update}crm.contact.update"
        update_query = {
            'id': entity['ID'],
            'fields': {"COMMENTS": comment}
        }
        response = requests.post(update_url, json=update_query)
        if response.status_code != 200:
            print(f"Ошибка при добавлении комментария к  с ID {entity['ID']}")



# Функция для создания нового контакта
def create_contact(phone_number, comment, responsible_id):
    create_url = f"{webhook_url_contact_add}crm.contact.add"
    contact_data = {
        'fields': {
            "PHONE": [{"VALUE": phone_number, "VALUE_TYPE": "WORK"}],
            "COMMENTS": comment,
            "ASSIGNED_BY_ID": responsible_id
        }
    }
    response = requests.post(create_url, json=contact_data)
    if response.status_code == 200:
        return response.json().get('result')

# Главная функция, которая обрабатывает звонок
def process_call(caller, callee, comment):
    # Определение, является ли номер телефона одним из менеджеров
    responsible_id = get_responsible_id(caller) or get_responsible_id(callee) or 1  # ID по умолчанию, если менеджер не найден

    # Поиск контакта по номеру телефона
    contacts = search_entities_contact(caller) + search_entities_contact(callee)
    if contacts:
        add_comment_to_entities_contact(contacts, comment)
        return "Комментарий добавлен к контактам."
    
    # Поиск компаний, если контакты не найдены
    companies = search_entities_company(caller) + search_entities_company('company', callee)
    if companies:
        add_comment_to_entities_company(companies, comment)
        return "Комментарий добавлен к компаниям."

    # Если контакты и компании не найдены, создаем новый контакт
    new_contact_id = create_contact(caller if not contacts else callee, comment, responsible_id)
    if new_contact_id:
        return f"Создан новый контакт с ID: {new_contact_id}."
    else:
        return "Ошибка при создании контакта."

# Пример вызова функции
caller = '123'  # Внутренний номер телефона менеджера, кто звонил
callee = '+380123456789'  # Номер телефона, кому звонили
comment = 'Это пример комментария для теста'
#print(process_call(caller, callee, comment))
get_all_managers()