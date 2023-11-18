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
        <h4>Urutonde rw'ibirangugwa muri Happy People Cosmetics shop : Le {{date('d-m-Y', strtotime($current))}}</h4>
    </div>



    <table id="customers">
        <tr>
            <th>#</th>
            <th>Produit</th>
            <th>Quantité </th>
            <th>Description</th>
        </tr>
        @if (count($item))
            @php
                $i = 1;
                $total = 0;
            @endphp
            @foreach ($item as $items)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $items->nameProduct }}</td>
                    <td>{{ $items->quantite }}</td>
                    <td>{{ $items->description }}</td>
                    @php
                        $totals = $items->prixTotal;
                        $total += $totals;
                    @endphp

                </tr>
            @endforeach
            @endif

    </table>

</body>

</html>
