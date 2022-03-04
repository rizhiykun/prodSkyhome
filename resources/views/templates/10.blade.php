<!DOCTYPE html><html>
                    <head>
                        <title>10</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <style>
                        body {
                                font-family: DejaVu Sans;
                                font-size: 18px;
                        }
                        .works {
                            border-collapse: collapse;
                        }

                        .works td, th{
                            border: solid 1px #ccc;
                        }
                    </style>
                    </head>
                    <body>
                    <div style="width: 100%; max-width: 960px; margin: auto">
                    <h1 class="ql-align-center">Смета
                        №{{ $data['doc_number'] ?? "1" }}</h1>
                    <h2 class="ql-align-center">Приложение к Договору N{{ $data['d_number'] ?? "0" }} от
                        {{ $data['d_date'] ?? "10.20.30" }}</h2>
                    <p class="ql-align-center">г. Краснодар {{ $data['date'] ?? "40.50.60" }}.</p>

                    <table style="width: 100%">
                        <tr>
                            <td>
                                <ul style="list-style: none">
                                    <li>Менеджер: {{ $data['manager'] ?? "Не назначен" }}</li>
                                    <li>Обоснование расчета: {{ $data['Rationale'] ?? "Не назначено" }}</li>
                                    <li>Заказчик: {{ $data['estimate.clientID'] ?? "Не назначен" }}</li>
                                    <li>Срок исполнения: {{ $data['time'] ?? "Не установлен" }}</li>
                                    <li>Объект: {{ $data['estimate.objectAddress']  ?? "Не выбран" }}</li>
                                    <li>Площадь: {{ $data['objectSquare'] ?? "Не назначена" }}</li>
                                </ul>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <div style="width: 100%; max-width: 960px; margin: auto">
                        <table class="works" style="border: 1px solid black; border-spacing: 2px">
                            @foreach ($data['works'] as $works => $k)
                                <tr style="font-weight: bold"><td>{{ $works }}</td></tr>
                                <tr>
                                    <td>Работа</td>
                                    <td>Обьем</td>
                                    <td>Цена</td>
                                </tr>
                                @foreach ($k as $work)
                                        <tr>
                                            <td>{{ $work['work'] }}</td>
                                            <td>{{ $work['volume'] }}</td>
                                            <td>{{ $work['price'] }}</td>
                                        </tr>
                                @endforeach
                            @endforeach
                        </table>
                        <p>1. Стоимость материала, его доставки и подъема в данный расчет не входит.</p>
                        <p>
                            2. Указанная стоимость работ является фиксированной и не меняется в процессе работ. Стоимость работ может
                            измениться в случае внесения Заказчиком изменений в проект, что может привести к увеличению трудоемкости и
                            объемов работ.
                        </p>

                        <h4>Смету в сумме: {{ $data['estimate_summary'] ?? "1000.01" }} руб.</h4>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 50%;">Составил:</td>
                                <td style="width: 50%;">Проверил: Гриненко А.В.</td>
                            </tr>
                        </table>
                        <br>

{{--                        <h4>Утверждаю:</h4>--}}
{{--                        <table style="width: 100%">--}}
{{--                            <tr>--}}
{{--                                <td style="width: 50%;">Директор--}}
{{--                                    ООО «Скайхоум»</td>--}}
{{--                                <td style="width: 50%;">_____________/Посикун Е.В.</td>--}}
{{--                            </tr>--}}
{{--                        </table>--}}
{{--                        <h4>Согласовано:</h4>--}}
{{--                        <table style="width: 100%">--}}
{{--                            <tr>--}}
{{--                                <td style="width: 50%;">Заказчик</td>--}}
{{--                                <td style="width: 50%;">_____________/{{ $data['client_name'] ?? "Заказчик" }}</td>--}}
{{--                            </tr>--}}
{{--                        </table>--}}

						<table width=100%>
	<tr>
		<td width="50%">Заказчик</td>
		<td width="50%">Исполнитель</td>
	</tr>
	<tr>
		<td width="50%">___________________ / ___________________</td>
		<td width="50%">___________________ / ___________________</td>
	</tr>
</table></div></div></body></html>
