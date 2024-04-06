/*
 Theme Name:   Woodmart Child
 Description:  Woodmart Child Theme
 Author:       XTemos
 Author URI:   http://xtemos.com
 Template:     woodmart
 Version:      1.0.0
 Text Domain:  woodmart
*/

/* Стили для формы поиска */
/* Стили для формы поиска WooCommerce */
/* Общие стили для формы */
.custom-search-form {
max-width: 1732px;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    margin: 0 auto; /* Центрирование формы */
    display: flex;
    flex-wrap: wrap; /* Для переноса полей на новую строку */
    justify-content: space-between; /* Равное расстояние между элементами */
    align-items: center; /* Центрирование по вертикали */
    border-radius: 10px;
    background: rgba(50, 50, 50, 0.6); /* Пример фона, можете настроить под свой дизайн */
}

.custom-search-field {
    flex: 1 1 auto; /* Гибкая настройка размера поля */
    margin: 10px; /* Отступ между полями */
}

.search-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff; /* Фон для поля ввода */
    color: #000; /* Цвет текста */
}


.custom-search-button {
    flex: 0 0 auto; /* Не изменять размер кнопки */
    width: 100%; /* Полная ширина для кнопки */
    text-align: center; /* Центрирование текста кнопки */
}

.search-button {
    padding: 10px 20px;
    background-color: #1C1C1C;
    color: #FFFFFF;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: auto; /* Автоматический размер по содержимому */
}

/* Позиционирование и стили для текста в форме */
.custom-search-form label {
    color: #FFFFFF;
    font-family: 'Rubik', sans-serif;
    font-size: 18px;
    line-height: 21px;
    text-transform: uppercase;
    display: block; /* Блочное отображение для размещения над полями */
    margin-bottom: 5px; /* Отступ от надписи до поля */
}

.label-radius {
    left: 1.91%;
    top: 11.22%;
}

.label-width {
    left: 15.36%;
    top: 11.22%;
}

.label-height {
    left: 1.91%;
    top: 21.79%;
}

/* Позиционирование и стили для инпутов в форме */
.custom-search-form input[type="text"] {
    position: absolute;
    width: 80%;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid #FFFFFF;
    color: #FFFFFF;
    font-family: 'Rubik', sans-serif;
    font-size: 20px;
    line-height: 24px;
}

.input-radius {
    left: 5.83%;
    top: 65.06%;
}

.input-width {
    left: 33.83%;
    top: 65.06%;
}

.input-height {
    left: 61.37%;
    top: 65.06%;
}

/* Позиционирование и стили для кнопки в форме */
.custom-search-form button {
    position: absolute;
    padding: 10px 20px;
    background-color: #1C1C1C;
    color: #FFFFFF;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button-search {
    left: 84.55%;
    top: 57.2%;
}
