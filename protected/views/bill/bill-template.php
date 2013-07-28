<div id="print">
  <div class="span3 pull-right">
  Внимание! Переход на условия работы по тарифному плану "Бизнес" на портале bilru.com осуществляется после поступления денежных средств на р/с Поставщика.                                       
</div>
<?php echo CHtml::image($this->createAbsoluteUrl('/')."/img/logo.png", '', array('style'=>'margin-bottom:50px;')) ?>

<br><br>
<table class="table invoice">
  <tr>
    <td colspan="42" style="border:none"><p align="center"><strong>Образец заполнения платежного поручения</strong></p></td>
  </tr>
  <tr>
    <td colspan="19" rowspan="2" style="border-bottom-color:#ccc">ОАО «Сбербанк России» г. Москва</td>
    <td colspan="3">БИК</td>
    <td colspan="20" style="border-bottom-color:#ccc">44525225</td>
  </tr>
  <tr>
    <td colspan="3" style="border-bottom:none">Сч. №</td>
    <td colspan="20" rowspan="2">30101810400000000000</td>
  </tr>
  <tr>
    <td colspan="19">Банк получателя</td>
  </tr>
  <tr>
    <td colspan="3" style="border-right-color:#ccc; padding-right:10px;">ИНН</td>
    <td colspan="7">7715961573</td>
    <td colspan="2" style="border-right-color:#ccc;padding-right:10px;">КПП</td>
    <td colspan="7">771501001</td>
    <td colspan="3" rowspan="3">Сч. №</td>
    <td colspan="20" rowspan="3">40702810638050000000</td>
  </tr>
  <tr>
    <td colspan="19" style="border-bottom-color:#ccc">ООО «Билру»</td>
  </tr>
  <tr>
    <td colspan="19">Получатель</td>
  </tr>
  <tr><td colspan="42" style="border:none; height:30px;"></td></tr>
  <tr>
    <td colspan="42" style="border:none; border-bottom:3px solid;"><strong>Счет на оплату № С<?php echo $bill->id  ?> от <?php echo date('d.m.Y',$bill->date);  ?></strong></td>
  </tr>
  <tr><td colspan="42" style="border:none; height:15px;"></td></tr>
  <tr>
    <td colspan="7" style="border:none; padding-right:20px;">Поставщик:</td>
    <td colspan="35" style="border:none;"><strong>ООО «Билру», ИНН 7715961573, КПП 771501001, 127106, Москва, Гостиничный проезд, д. 6, корп.2</strong></td>
  </tr>
  <tr><td colspan="42" style="border:none; height:15px;"></td></tr>
  <tr>
    <td colspan="7" style="border:none; padding-right:20px;">Покупатель:</td>
    <td colspan="35" style="border:none;"><strong><?php echo $bill->user->orgType->org_type_name . ' ' . $bill->user->organizationData->org_name ?>, ИНН <?php echo $bill->user->organizationData->inn  ?>, КПП <?php echo $bill->user->organizationData->kpp ?></strong></td>
  </tr>
  <tr><td colspan="42" style="border:none; height:15px;"></td></tr>
  <tr>
    <th colspan="3" style="text-align:center; border-left-width:3px; border-top-width:3px;">№</th>
    <th colspan="21" style="text-align:center; border-top-width:3px;">Товары (работы, услуги)</th>
    <th colspan="5" style="text-align:center; border-top-width:3px;">Кол-во</th>
    <th colspan="3" style="text-align:center; border-top-width:3px;">Ед.</th>
    <th colspan="5" style="text-align:center; border-top-width:3px;">Цена</th>
    <th colspan="5" style="text-align:center; border-top-width:3px; border-right-width:3px;">Сумма</th>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center;border-left-width:3px; border-bottom-width:3px;">1</td>
    <td colspan="21" style="border-bottom-width:3px;">Тариф <?php echo $bill->tarif->name ?> для юридических лиц. <?php echo $bill->terms[$bill->term] ?>.</td>
    <td colspan="5" style="text-align:center;border-bottom-width:3px;"><?php echo $bill->term ?></td>
    <td colspan="3" style="text-align:center;border-bottom-width:3px;">шт</td>
    <td colspan="5" style="text-align:right;border-bottom-width:3px;"><?php echo number_format($bill->tarif->price, 2, ',', ' ') ?></td>
    <td colspan="5" style="text-align:right;border-bottom-width:3px;border-right-width:3px;"><?php echo number_format($bill->sum, 2, ',', ' ')  ?></td>
  </tr>
<tr><td colspan="42" style="border:none; height:15px;"></td></tr>
  <tr>
    <td colspan="24" style="border:none"></td>
    <th colspan="13" style="border:none; text-align:right">Итого:</th>
    <th colspan="5" style="border:none; text-align:right"><?php echo number_format($bill->sum, 2, ',', ' ') ?></th>
  </tr>
  <tr>
    <td colspan="24" style="border:none"></td>
    <th colspan="13" style="border:none; text-align:right">Без налога НДС:</th>
    <th colspan="5" style="border:none; text-align:right">-</th>
  </tr>
  <tr>
    <td colspan="24" style="border:none"></td>
    <th colspan="13" style="border:none; text-align:right">Всего к оплате:</th>
    <th colspan="5" style="border:none; text-align:right"><?php echo number_format($bill->sum, 2, ',', ' ') ?></th>
  </tr>
  <tr>
    <td colspan="42" style="border:none">Всего наименований 1, на сумму <?php echo number_format($bill->sum, 2, ',', ' ') ?> руб</td>
  </tr>
  <tr><td colspan="42" style="border:none; height:15px;"></td></tr>
  <tr>
    <td colspan="42"  style="border:none;border-top:3px solid"><?php echo CHtml::image($this->createAbsoluteUrl('/') . '/img/pechat.jpg', '', array('style'=>'width:100%')) ?></td>
  </tr>  
</table>
</div>