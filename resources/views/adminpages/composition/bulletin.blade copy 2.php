<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
            background-color: #f9f9f9;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        table th {
            background-color: #ddd;
        }

        .fusion {
            text-align: center;
            font-weight: bold;
            background-color: #f1f1f1;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                margin: 0;
                padding: 10px;
                border: none;
                page-break-inside: avoid;
            }

            table {
                font-size: 10px;
            }

            .signature-section div {
                text-align: center;
                font-size: 10px;
            }

            .header h1 {
                font-size: 16px;
            }

            .header p {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>Lycée Privé Jeunesse Pour Christ</h1>
            <p>Bulletin de Notes - Premier Trimestre</p>
        </div>

        <!-- Informations générales -->
        <table>
            <tr>
                <td><strong>Année Scolaire :</strong> 2024-2025</td>
                <td><strong>Effectif :</strong> 50</td>
            </tr>
            <tr>
                <td><strong>Nom :</strong> KEBE</td>
                <td><strong>Classe :</strong> 1ère C</td>
            </tr>
            <tr>
                <td><strong>Prénom :</strong> Wendemi Noël</td>
                <td><strong>Classe Redoublée :</strong> Non</td>
            </tr>
            <tr>
                <td><strong>Date de Naissance :</strong> 02/09/2006</td>
                <td></td>
            </tr>
        </table>

        <!-- Matières Littéraires -->
        <table>
            <thead>
                <tr>
                    <th>Matières</th>
                    <th>Notes</th>
                    <th>Surveillance</th>
                    <th>Coefficient</th>
                    <th>Notes Pondérées</th>
                    <th>Appréciation</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fusion" colspan="7">Matières Littéraires</td>
                </tr>
                <tr>
                    <td>Français</td>
                    <td>14</td>
                    <td>10</td>
                    <td>4</td>
                    <td>56</td>
                    <td>Bien</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Histoire</td>
                    <td>15</td>
                    <td>9</td>
                    <td>3</td>
                    <td>45</td>
                    <td>Très Bien</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Philosophie</td>
                    <td>12</td>
                    <td>8</td>
                    <td>2</td>
                    <td>24</td>
                    <td>Passable</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="fusion">Total des Matières Littéraires</td>
                    <td>9</td>
                    <td>125</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>

        <!-- Matières Scientifiques -->
        <table>
            <thead>
                <tr>
                    <th>Matières</th>
                    <th>Notes</th>
                    <th>Surveillance</th>
                    <th>Coefficient</th>
                    <th>Notes Pondérées</th>
                    <th>Appréciation</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fusion" colspan="7">Matières Scientifiques</td>
                </tr>
                <tr>
                    <td>Mathématiques</td>
                    <td>18</td>
                    <td>9</td>
                    <td>4</td>
                    <td>72</td>
                    <td>Excellent</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Physique</td>
                    <td>14</td>
                    <td>7</td>
                    <td>3</td>
                    <td>42</td>
                    <td>Bien</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Chimie</td>
                    <td>12</td>
                    <td>6</td>
                    <td>2</td>
                    <td>24</td>
                    <td>Passable</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="fusion">Total des Matières Scientifiques</td>
                    <td>9</td>
                    <td>138</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
