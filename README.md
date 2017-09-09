# payment-hs-btn
Yandex.Money and WebMoney payment buttons for HikaShop (for order page)
Кнопки оплаты Яндекс.Денег и WebMoney для HikaShop (на странице заказа)

Чтобы добавить кнопки оплаты на страницу заказа, выполните следующие шаги:

1. Переопределите представление show.php в HikaShop. Для этого скопируйте файл /components/com_hikashop/views/order/tmpl/show.php в директорию templates/ВАШ_ШАБЛОН/html/com_hikashop/order. Если такой папки нет - создайте ее.

2. Откройте скопированный файл show.php и добавьте следующую строку в указанное место:

Строка:

<?php include 'payment_buttons.php'; ?>

Чтобы получилось следующее:

<fieldset>
...
<?php include 'payment_buttons.php'; ?>
</fieldset>
<form action="<?php echo hikashop_completeLink('order'.$url_itemid); ?>" method="post" name="adminForm" id="adminForm">
...
</form>

3. Скопируйте файл payment_buttons.php в папку templates/ВАШ_ШАБЛОН/html/com_hikashop/order. В данной папке у вас уже находится файл show.php.

4. Измените файл payment_buttons.php в соответствии с вашими настройками. Для этого изучите комментарии внутри файла.

5. Не обязательно. Вы можете добавить стили из файла style.css в ваш файл шаблона. Или в templates/ВАШ_ШАБЛОН/css/template.css, или в templates/ВАШ_ШАБЛОН/css/custom.css.

6. Готово! На странице конкретного заказа, если его статус и выбранный способ оплаты соответствуют указанным в настройках файла payment_buttons.php параметрам, будут отображаться кнопки оплаты.
