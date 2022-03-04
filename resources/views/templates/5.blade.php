<!DOCTYPE html><html>
                    <head>
                        <title>5</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <style>
                        body {
                                font-family: DejaVu Sans;
                                font-size: 18px;
                        }
                    </style>
                    </head>
                    <body><div style="width: 100%; max-width: 960px; margin: auto"><h1>Акт N2</h1><h1><br></h1><h1>к	Договору N{{ $data['d_number'] }} от {{ $data['d_date'] }}</h1><h1>о создании дизайн-проекта интерьера</h1><p><br></p><p>г. Краснодар	{{ $data['date'] }}.</p><p><br></p><p>{{ $data['clientName'] }}, именуемый(-мая) в дальнейшем «Заказчик», с одной стороны, и ООО "СКАЙХОУМ", именуемое в дальнейшем «Исполнитель», в лице директора Посикуна Евгения Викторовича, действующего на основании Устава, с другой стороны, составили настоящий акт о нижеследующем:</p><p>1.	Исполнитель выполнил, а Заказчик принял этап работ “3D визуализация”, состоящий из следующих документов / работ:</p><p>фотореалистичных 3d-визуализаций&nbsp;</p><p>2.	Качество выполненных работ соответствует Техническому заданию, выданному Заказчиком Исполнителю. Претензии по качеству, объему и срокам выполнения работ Заказчик не имеет.</p><p>3.	Стоимость выполненных работ по этапу составила СТОИМОСТЬ ЭТАПА ИЗ ДОГОВОРА НА УМНОЖЕННАЯ ПЛОЩАДЬ (МОЖНО ПРОСТО ФОРМУЛОЙ ПРОПИСАТЬ) без НДС.</p><p>4.	Настоящий Акт составлен в двух экземплярах, имеющих одинаковую юридическую силу, по одному для каждой из сторон.</p><p>5.	Адреса, банковские реквизиты и подписи сторон:</p><p><br></p><table style="page-break-before: always;" width=100%>
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