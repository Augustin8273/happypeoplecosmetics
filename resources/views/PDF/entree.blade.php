<!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #390101;
            color: white;
        }

        .container {
            text-align: center;
        }
        .contPic {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="contPic">
        <img src="Hpc/assets/img/hpc.png" height="100" rel="logo" alt="logo">
    </div>
    <div class="container">
        <h1>Happy People Cosmetics (HPC)</h1>
    </div>
    <div class="">
        <h4>Historique de tous les entrees jusqu'a la date actuelle : le {{date('d-m-Y', strtotime($current))}}</h4>
    </div>
    <table id="customers">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Produit</th>
            <th scope="col">Category</th>
            <th scope="col">Quantite</th>
            <th scope="col">Prix unitaire</th>
            <th scope="col">Prix total</th>
        </tr>
        @if (count($product))
            @php
                $i = 1;
                $total = 0;
            @endphp
            @foreach ($product as $items)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $items->Produitname->nameProduct }}</td>
                    <td>{{ $items->Category->nameCategory }}</td>
                    <td>{{ $items->quantity }}</td>
                    <td>{{ $items->unitPrice }}</td>
                    <td>{{ $items->totalPrice }}</td>
                    @php
                        $totals = $items->totalPrice;
                        $total += $totals;
                    @endphp

                </tr>
            @endforeach
            @endif
            <tr><td colspan="6"></td></tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="2">
                    <span style="padding:6px;color:white;background:#390101;">
                        Valeur de tous les entrees : {{ number_format($total,2) }}
                        Fbu</span>
                </td>
            </tr>
            <tr><td colspan="6"></td></tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="1">Imprime  Le : {{date('d-m-Y', strtotime($current))}}</td>
            </tr>

    </table>

</body>

</html>
