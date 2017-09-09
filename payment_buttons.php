<?php
/**
 * @package	Yandex.Money and WebMoney payment buttons for HikaShop (for order page)
 * @version	1.0
 * @author	Alex Feel
 * @copyright (C) 2017 Alex Feel. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

$lang = JFactory::getLanguage();
?>

<!-- Укажите ваши данные ниже этой строки -->
<?php
  // ID способа оплаты, при котором должны отображаться кнопки оплаты на странице заказа
  // Например, предварительная оплата
  $order_payment_method_id = 2;

  // Статус заказа, при котором должны отображаться кнопки оплаты на странице заказа
  // Как правило, это статус "В ожидании оплаты"
  $order_status_name = 'pending';

  // Номера ваших счетов
  // Яндекс.Деньги
  $ya_money_purse = '400000000000000';
  // WebMoney
  $webmoney_purse = 'R000000000000';
  
  // Адреса страниц вашего сайта, отображающие результаты оплаты
  // Страница с результатом успешной оплаты через Яндекс.Деньги
  $successful_ya_money_payment_url = 'https://site.com/successful_payment';

  // $webmoney_result_url = 'https://site.com/webmoney_result';
  // Страница с результатом успешной оплаты через WebMoney
  $successful_webmoney_payment_url = 'https://site.com/successful_payment';
  // Страница с результатом неудачной оплаты через WebMoney
  $failed_webmoney_payment_url = 'https://site.com/failed_payment';
?>

<!-- Не изменяйте данные ниже этой строки -->
<?php if(($this->order->order_payment_id) == $order_payment_method_id && ($this->element->order_status) == $order_status_name): ?>
	<?php
		// Номер заказа
		if($this->invoice_type == 'order' || empty($this->element->order_invoice_number)) {
			$order_number = $this->element->order_number;
		} else {
			$order_number = $this->element->order_invoice_number;
		}

		// Дата заказа
		if($this->invoice_type == 'order' || empty($this->element->order_invoice_created)) {
			$order_date = hikashop_getDate($this->element->order_created, '%d %B %Y');
		} else {
			$order_date = hikashop_getDate($this->element->order_invoice_created, '%d %B %Y');
		}

		// Сумма заказа
		$order_sum = $this->order->order_full_price;

		// Назначение платежа
		$payment_target = JText::_('PAYMENT_OF_ORDER_NO') . $order_number . JText::_('PAYMENT_OF_ORDER_OF') . $order_date;

		// Уникальный номер покупки для целей идентификации платежа, требует WebMoney
		$payment_no = $this->element->order_id;
	?>
	<div class="payment-buttons">
		<legend><?php echo JText::_('PAYMENT_METHODS'); ?></legend>

		<!-- Оплата с банковской карты на счет Яндекс.Денег -->
    <div class="payment-buttons-block">
			<p><?php echo JText::_('PAYMENT_BY_BANK_CARD'); ?></p>
			<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml" target="_blank">
				<input type="hidden" name="receiver" value="<?php print $ya_money_purse; ?>">
				<input type="hidden" name="quickpay-form" value="shop">
				<input type="hidden" name="targets" value="<?php print $payment_target; ?>">
				<input type="hidden" name="paymentType" value="AC">
				<input type="hidden" name="sum" value="<?php print $order_sum; ?>" data-type="number">
				<input type="hidden" name="label" value="<?php print $order_number; ?>">
				<input type="hidden" name="successURL" value="<?php print $successful_ya_money_payment_url; ?>">
				<button class="btn btn-primary"><?php echo JText::_('PAY_NOW'); ?></button>
			</form>
		</div>

    <!-- Оплата со счета Яндекс.Денег на счет Яндекс.Денег -->
		<div class="payment-buttons-block">
			<p><?php echo JText::_('PAYMENT_FROM_YANDEX_MONEY'); ?></p>
			<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml" target="_blank">
				<input type="hidden" name="receiver" value="<?php print $ya_money_purse; ?>">
				<input type="hidden" name="quickpay-form" value="shop">
				<input type="hidden" name="targets" value="<?php print $payment_target; ?>">
				<input type="hidden" name="paymentType" value="PC">
				<input type="hidden" name="sum" value="<?php print $order_sum; ?>" data-type="number">
				<input type="hidden" name="label" value="<?php print $order_number; ?>">
				<input type="hidden" name="successURL" value="<?php print $successful_ya_money_payment_url; ?>">
				<button class="btn btn-primary"><?php echo JText::_('PAY_NOW'); ?></button>
			</form>
		</div>
		
    <!-- Оплата разными способами на счет WebMoney -->
    <div class="payment-buttons-block">
			<p><?php echo JText::_('PAYMENT_WITH_WEBMONEY'); ?></p>
			<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST" target="_blank">
				<input type="hidden" name="LMI_PAYEE_PURSE" value="<?php print $webmoney_purse; ?>">
				<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php print $order_sum; ?>">
				<input type="hidden" name="LMI_PAYMENT_NO" value="<?php print $payment_no; ?>">
				<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="<?php print base64_encode($payment_target); ?>">
				<!-- <input type="hidden" name="LMI_RESULT_URL" value="<?php print $webmoney_result_url; ?>"> -->
				<input type="hidden" name="LMI_SUCCESS_URL" value="<?php print $successful_webmoney_payment_url; ?>">
				<input type="hidden" name="LMI_FAIL_URL" value="<?php print $failed_webmoney_payment_url; ?>">
				<button class="btn btn-primary"><?php echo JText::_('PAY_NOW'); ?></button>
			</form>
		</div>
		
    <!-- Кнопка "Другие способы (терминалы, банкинг и др.)", открывающая статью с описание других способ оплаты -->
    <!-- Раскомментируйте и укажите ссылки на выши статьи, если необходимо -->
    <!-- <div class="payment-buttons-block">
			<p><?php echo JText::_('OTHER_PAYMENT_METHODS'); ?></p>
			<?php if($lang->getTag() == 'en-GB') : ?>
				<a href="index.php?option=com_content&view=article&id=4" class="btn btn-primary" role="button" target="_blank"><?php echo JText::_('VIEW_NOW'); ?></a>
			<?php else : ?>
				<a href="index.php?option=com_content&view=article&id=3" class="btn btn-primary" role="button" target="_blank"><?php echo JText::_('VIEW_NOW'); ?></a>
			<?php endif; ?>
		</div> -->
	</div>
<?php endif; ?>
