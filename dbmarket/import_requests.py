import requests
import time
import hmac
import hashlib
import json
import nacl.signing
import nacl.encoding
import os
import datetime

class DMarketAPI:
    API_KEY = "00e084699ba68e9a509d13f80e0e1205282dc6fe480b1fed27ff73a420eaa5a8"
    SECRET_KEY = "8a058cc2865b0ac68de99df28ecbb4fabaff68ca1ba29065d96e9f98fccb0b5200e084699ba68e9a509d13f80e0e1205282dc6fe480b1fed27ff73a420eaa5a8"
    BASE_URL = "https://api.dmarket.com"
    ignore_list_file = 'ignore_list.json'
    minimum_prices_file = 'minimum_prices.json'

    def __init__(self):
        self.ignore_list = self.load_ignore_list()
        self.minimum_prices = self.load_minimum_prices()

    @staticmethod
    def create_signature(method, path, query_string, body, timestamp):
        message = f"{method}{path}{query_string}{body}{timestamp}".encode('utf-8')
        signing_key = nacl.signing.SigningKey(bytes.fromhex(DMarketAPI.SECRET_KEY[:64]))
        signed = signing_key.sign(message)
        return signed.signature.hex()

    def get_user_offers(self, game_id):
        path = "/marketplace-api/v1/user-offers"
        query_string = f"?gameId={game_id}"
        url = self.BASE_URL + path + query_string
        timestamp = str(int(time.time()))
        signature = self.create_signature("GET", path, query_string, "", timestamp)
        headers = {
            "X-Api-Key": self.API_KEY,
            "X-Sign-Date": timestamp,
            "X-Request-Sign": "dmar ed25519 " + signature,
        }
        response = requests.get(url, headers=headers)
        return response.json()

    def get_market_items(self, game_id, title):
        path = "/exchange/v1/market/items"
        currency = "USD"
        limit = 100  # Указываем, что хотим получить до 10 предметов
        query_string = f"?gameId={game_id}&title={title}&currency={currency}&limit={limit}"  # Добавляем параметр limit в запрос
        url = self.BASE_URL + path + query_string
        timestamp = str(int(time.time()))
        signature = self.create_signature("GET", path, query_string, "", timestamp)
        headers = {
            "X-Api-Key": self.API_KEY,
            "X-Sign-Date": timestamp,
            "X-Request-Sign": "dmar ed25519 " + signature,
        }
        response = requests.get(url, headers=headers)
        return response.json()


    def edit_offer_price(self, offer_id, new_price):
        path = "/marketplace-api/v1/user-offers/edit"
        body = json.dumps({
    "Offers": [
        {
            "OfferID": offer_id,
            "Price": {
                "Currency": "USD",  # Пример использования валюты
                "Amount": new_price
            }
        }
    ]
})

        timestamp = str(int(time.time()))
        signature = self.create_signature("POST", path, "", body, timestamp)
        headers = {
            "X-Api-Key": self.API_KEY,
            "X-Sign-Date": timestamp,
            "X-Request-Sign": "dmar ed25519 " + signature,
            "Content-Type": "application/json"
        }
        response = requests.post(self.BASE_URL + path, headers=headers, data=body)
        return response.json()

    def adjust_price_to_be_cheapest(self, game_id):
        ignore_list = self.load_ignore_list()
        minimum_prices = self.load_minimum_prices()
        user_offers = self.get_user_offers(game_id)['Items']
        user_offer_ids = [offer['Offer']['OfferID'] for offer in user_offers]  # Список идентификаторов предложений пользователя

        for offer in user_offers:
            if offer['Title'] in ignore_list.get('titles', []) or offer['Offer']['OfferID'] in ignore_list.get('offerIDs', []):
                continue

            market_items = self.get_market_items(game_id, offer['Title'])
            if not market_items['objects']:
                continue

        # Фильтрация предложений на рынке, исключая собственные предложения пользователя
            competitive_offers = [item for item in market_items['objects'] if 'offerId' in item and item['offerId'] not in user_offer_ids]

            if not competitive_offers:  # Если не осталось конкурентных предложений после фильтрации
                continue

            lowest_market_price = min(float(item['price']['USD']) for item in competitive_offers if 'price' in item and 'USD' in item['price']) / 100
            minimum_price = minimum_prices.get(offer['Title'], None)

            if minimum_price is not None and lowest_market_price < minimum_price:
                new_price = minimum_price
            else:
                new_price = max(lowest_market_price - 0.01, 0.01)  # Предотвращение отрицательной цены

            if new_price != float(offer["Offer"]["Price"]["Amount"]):
                self.edit_offer_price(offer['Offer']['OfferID'], new_price)
                self.log_action(f"Цена для {offer['Title']} установлена на {new_price} USD.")
                print(f"Цена для {offer['Title']} установлена на {new_price} USD.")






    def load_ignore_list(self):
        try:
            with open(self.ignore_list_file, 'r') as file:
                ignore_list = json.load(file)
        except (FileNotFoundError, json.JSONDecodeError):
            ignore_list = {"titles": [], "offerIDs": []}
            with open(self.ignore_list_file, 'w') as file:
                json.dump(ignore_list, file, indent=4)
        return ignore_list


    def load_minimum_prices(self):
        if os.path.exists(self.minimum_prices_file) and os.path.getsize(self.minimum_prices_file) > 0:
            with open(self.minimum_prices_file, 'r') as file:
                return json.load(file)
        else:
            return {}

    def remove_minimum_price(self, title):
        if not os.path.exists(self.minimum_prices_file):
            print("Minimum prices file does not exist.")
            return
        
        with open(self.minimum_prices_file, 'r+') as file:
            minimum_prices = json.load(file)
            if title in minimum_prices:
                del minimum_prices[title]
                file.seek(0)
                json.dump(minimum_prices, file, indent=4)
                file.truncate()
                self.log_action("Delite minimal price ${title}")
                print(f"Minimum price setting removed for {title}.")
            else:
                print(f"No minimum price setting found for {title}.")

    def log_action(self, action):
        """Записывает действие в файл логов."""
        with open('logs.txt', 'a') as log_file:
            timestamp = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            log_file.write(f"{timestamp}, {action}\n")

    def set_minimum_price(self, title, price):
        try:
            with open(self.minimum_prices_file, 'r+') as file:
                try:
                    minimum_prices = json.load(file)
                except json.JSONDecodeError:
                    # File is empty, initializing minimum_prices with an empty dict
                    minimum_prices = {}
                minimum_prices[title] = price
                file.seek(0)
                json.dump(minimum_prices, file, indent=4)
                file.truncate()
            print(f"Minimum price for {title} set to ${price}")
            self.log_action("Edit fo minimal {title} на {price}")
        except FileNotFoundError:
            # File does not exist, creating the file and initializing it with the provided title and price
            with open(self.minimum_prices_file, 'w') as file:
                json.dump({title: price}, file, indent=4)
            print(f"Minimum price for {title} set to ${price} and file created")



    def view_minimum_prices(self):
        """Просмотр текущих ограничений на минимальную цену."""
        if not os.path.exists(self.minimum_prices_file):
            print("Файл с минимальными ценами не существует.")
            return

        with open(self.minimum_prices_file, 'r') as file:
            minimum_prices = json.load(file)
            if minimum_prices:
                print("Текущие ограничения на минимальную цену:")
                for title, price in minimum_prices.items():
                    print(f"{title}: ${price}")
            else:
                print("Ограничения на минимальную цену не установлены.")


    def add_to_ignore_list(self, title=None, offer_id=None):
        ignore_list = self.load_ignore_list()

        if title and title not in ignore_list["titles"]:
            ignore_list["titles"].append(title)
            self.log_action(f"Added to ignore list: {title}")

        if offer_id and offer_id not in ignore_list["offerIDs"]:
            ignore_list["offerIDs"].append(offer_id)
            self.log_action(f"Added to ignore list: {offer_id}")

        with open(self.ignore_list_file, 'w') as file:
            json.dump(ignore_list, file, indent=4)

    def view_ignore_list(self):
        ignore_list = self.load_ignore_list()

        if not ignore_list["titles"] and not ignore_list["offerIDs"]:
            print("Ignore list is empty.")
        else:
            if ignore_list["titles"]:
                print("Ignored titles:")
                for title in ignore_list["titles"]:
                    print(f"- {title}")

            if ignore_list["offerIDs"]:
                print("Ignored offer IDs:")
                for offer_id in ignore_list["offerIDs"]:
                    print(f"- {offer_id}")

    def remove_from_ignore_list(self, title=None, offer_id=None):
        ignore_list = self.load_ignore_list()

        if title and title in ignore_list["titles"]:
            ignore_list["titles"].remove(title)
            self.log_action(f"Removed from ignore list: {title}")

        if offer_id and offer_id in ignore_list["offerIDs"]:
            ignore_list["offerIDs"].remove(offer_id)
            self.log_action(f"Removed from ignore list: {offer_id}")

        with open(self.ignore_list_file, 'w') as file:
            json.dump(ignore_list, file, indent=4)

    def user_interface(self):
        while True:
            print("\nИнтерфейс бота по ценообразованию на DMarket")
            print("1. Установить минимальную цену для скина")
            print("2. Добавить скин в список игнорируемых")
            print("3. Показать текущие предложения - CS:GO - a8db, Team Fortress 2 - tf2, Dota 2 - 9a92, Rust - rust")
            print("4. Настроить цены, чтобы быть самыми дешевыми - CS:GO - a8db, Team Fortress 2 - tf2, Dota 2 - 9a92, Rust - rust")
            print("5. Открыть игнор. лист")
            print("6. Удалить из игнор. листа")
            print("7. Удалить минимальную цену на офер")
            print("8. Просмотр ограничений на минимальную цену.")
            print("9. Выйти")
            choice = input("Введите ваш выбор: ")
        
            if choice == '1':
                title = input("Введите название скина: ")
                price = float(input("Введите минимальную цену: "))
                self.set_minimum_price(title, price)
                print(f"Минимальная цена для {title} установлена на ${price}")
        
            elif choice == '2':
                ignore_choice = input("Игнор по title (t) или OfferID (o)? ")
                if ignore_choice.lower() == 't':
                    title = input("Введи title для добавления в список: ")
                    self.add_to_ignore_list(title=title)
                elif ignore_choice.lower() == 'o':
                    offer_id = input("Введи OfferID для добавления в список: ")
                    self.add_to_ignore_list(offer_id=offer_id)

            elif choice == '3':
                game_id = input("Введите ID игры: ")
                offers = self.get_user_offers(game_id)
                for offer in offers['Items']:
                    title = offer["Title"]
                    price_currency = offer["Offer"]["Price"]["Currency"]
                    price_amount = offer["Offer"]["Price"]["Amount"]
                    offer_id = offer["Offer"]["OfferID"]
                    print(f"OfferID: {offer_id}, Title: {title}, Price: {price_currency} {price_amount}")

        
            elif choice == '4':
                game_id = input("Введите ID игры для корректировки цены. CS:GO - a8db, Team Fortress 2 - tf2, Dota 2 - 9a92, Rust - rust. ")
                self.adjust_price_to_be_cheapest(game_id)
                print("Цены скорректированы, чтобы быть самыми дешевыми на рынке.")
        
            elif choice == '5':
                self.view_ignore_list()

            elif choice == '6':
                remove_choice = input("RУдалить по title (t) или OfferID (o)? ")
                if remove_choice.lower() == 't':
                    title = input("Введи title для удаления из ignore list: ")
                    self.remove_from_ignore_list(title=title)
                elif remove_choice.lower() == 'o':
                    offer_id = input("Введи OfferID для удаления из ignore list: ")
                    self.remove_from_ignore_list(offer_id=offer_id)

            elif choice == '7':
                title = input("Введите title skin для удаления минимальной цены: ")
                self.remove_minimum_price(title)

            if choice == '8':
                self.view_minimum_prices()

            elif choice == '9':
                print("Exiting...")
                break

            else:
                print("Неверный выбор. Пожалуйста, попробуйте снова.")

if __name__ == "__main__":
    dmarket_api = DMarketAPI()
    dmarket_api.user_interface()