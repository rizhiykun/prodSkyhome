<!DOCTYPE html><html>
                    <head>
                        <title>13</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <style>
                        body {
                                font-family: DejaVu Sans;
                                font-size: 18px;
                        }
                    </style>
                    </head>
                    <body><div style="width: 100%; max-width: 960px; margin: auto"><h1 class="ql-align-center">АКТ СДАЧИ – ПРИЕМКИ ОБЪЕКТА</h1><h2 class="ql-align-center">по договору подряда №{{ $data['number'] }} ОТ {{ $data['creation_date'] }}</h2><p class="ql-align-center">г.&nbsp;Краснодар		 {{ $data['date'] }}</p><p>{{ $data['client_name'] }}, именуемый в дальнейшем «Заказчик», с одной стороны, и ООО "Скайхоум", именуемое в дальнейшем «Подрядчик», в лице директора Посикуна Евгения Викторовича, действующего на основании Устава, с другой стороны, подписали настоящий акт о нижеследующем:</p><p>1.&nbsp;&nbsp;«Подрядчик» выполнил все виды работ на объекте: {{ $data['address'] }} согласно договору&nbsp;подряда №{{ $data['number'] }} ОТ {{ $data['creation_date'] }}</p><p>2.&nbsp;Стоимость фактически выполненных работ и закупленных материалов составляет: {{ $data['client_payments'] }}&nbsp;без НДС.</p><p>3.&nbsp;Претензий по выполненным работам и оплате&nbsp;Стороны к друг другу не имеют.&nbsp;</p><p>4.&nbsp;«Заказчик» принял объект и к срокам, качеству и объему выполненных работ (оказанных услуг), закупленных материалов претензий не имеет.</p><p>5.&nbsp;Настоящий акт вступает в силу с даты его подписания Сторонами и&nbsp;является&nbsp;неотъемлемой частью Договора.&nbsp;</p><table style="page-break-before: always;" width=100%>
        <tr>
            <td style="padding-bottom: 30px" width="50%" align=center>Заказчик</td>
            <td style="padding-bottom: 30px" width="50%" align=center>Исполнитель</td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <div style="padding-left: 10px;">{!! $data['client'] !!}</div>
            </td>
            <td valign="top" width="50%">
                <div style="padding-left: 10px;">{!! $data['company'] !!}</div>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding-top: 30px;">___________________/_____________/</td>
            <td width="50%" style="padding-top: 30px;">___________________/_____________/</td>
        </tr>
    </table></div></body></html>