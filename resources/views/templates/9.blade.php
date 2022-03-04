<!DOCTYPE html>
<html>
<head>
    <title>9</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div style="width: 100%; max-width: 960px; margin: auto"><h1 class="ql-align-center">Дополнительное соглашение
        №{{ $data['doc_number'] }}</h1>
    <p class="ql-align-center"><br></p>
    <h2 class="ql-align-center">к Договору N{{ $data['d_number'] }} от {{ $data['d_date'] }}</h2>
    <h2 class="ql-align-center">о создании дизайн-проекта интерьера</h2>
    <p><br></p>
    <p class="ql-align-center">г. Краснодар {{ $data['date'] }}.</p>
    <p><br></p>
    <p><br></p>
    <p>{{ $data['clientName'] }}, именуемый(-мая) в дальнейшем «Заказчик», с одной стороны, и ООО "СКАЙХОУМ", именуемое
        в дальнейшем «Исполнитель», в лице директора Посикуна Евгения Викторовича, действующего на основании Устава, с
        другой стороны, заключили настоящее Дополнительное соглашение о нижеследующем:</p>
    <p>1. Фактический объем выполняемого дизайн-проекта помещения по адресу: адрес объекта увеличивается
        на {{ $data['add_square'] }} м2 и составляет&nbsp;{{ $data['square'] }} м2, что подтверждается обмерным
        планом.</p>
    <p>2. Общая стоимость работ по договору увеличивается на {{ $data['add_cost'] }} руб. и
        составляет: {{ $data['cost'] }} исходя из новой площади без НДС.</p>
    <p>3. Настоящее Соглашение вступает в силу с момента его подписания сторонами.</p>
    <p>4. Настоящее Соглашение составлено в двух экземплярах, имеющих одинаковую юридическую силу, по одному экземпляру
        для каждой из сторон.</p>
    <table style="page-break-before: always;" width=100%>
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
    </table>
</div>
</body>
</html>
