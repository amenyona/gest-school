<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ma Page avec Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers une feuille de styles CSS -->
    <style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin-left: 100px;
}

table {
    border-collapse: collapse;
    width: 50%;
    text-align: center;
    border: 1px solid #ccc;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
}

th {
    background-color: #f4f4f4;
}

    </style>
    
</head>
<body>

    <header>
        <div style="text-align: center">
        <h1>LYCEE PRIVE JEUNESSE POUR CHRIST</h1>
            <p>J.P.C</p>
                 <p>B.P 8217 OUAGADOUGOU</p>
                 <p>TEL: 25 43 52 81 - BURKINA FASO</p>
        </div>
                 
    </header>



    <main>


        <section id="section2" style="align-content: center">
            <h2>Rapport Financier Liste des Paiements Soldés - {{retreiveAnnee(session()->get('keyannee'))}}</h2>
            <table border="1" cellspacing="0" cellpadding="10" >
                <thead>
                    <tr>
                        <th>Eleve</th>
                        <th>Classe</th>
                        <th>Tranche Versement</th>
                        <th>Restant</th>
                        
                    </tr>
                    </thead>

                    <body>

                        @foreach ($paiements as $item)
                            <tr>
                      @if(remainScolarite($item->anneeacademique_id, $item->classe_id, $item->eleve_id)==0)
                                <td>{{retreiveIdEleve($item->eleve_id)}}</td>
                                <td>{{retreiveClasse($item->classe_id)}}</td>
                                <td>{{$item->montanttotal}} F CFA</td>
                                <td>{{remainScolarite($item->anneeacademique_id, $item->classe_id, $item->eleve_id)}} F CFA</td>
                      @endif          
                             
                                
                            </tr>
                        @endforeach                    
   
                    </body>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Amenyona Enyo LATE</p>
    </footer>

    <script src="scripts.js"></script> <!-- Lien vers un fichier JavaScript -->
</body>
</html>
