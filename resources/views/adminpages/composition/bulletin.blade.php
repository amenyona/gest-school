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
            width: 210mm; /* Largeur A4 */
            max-width: 100%;
            height: auto;
            margin-left: -20px;
            padding: 20px;
            
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

        .table-container {
            /*margin-bottom: 20px;*/
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: -10px;
            font-size: 12px; /* Réduction pour éviter l'encombrement */
        }

        table th, table td {
            border: 1px solid #000;
            padding: 1px;
            text-align: center;
        }

        table th {
            background-color: #ddd;
        }

        .fusion {
            text-align: center;
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature-section div {
            text-align: center;
            width: 45%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm; /* Hauteur A4 */
            }

            .container {
                margin: 0;
                padding: 20mm; /* Marges internes pour l'impression */
                border: none;
                page-break-inside: avoid; /* Empêche la coupure du contenu */
            }

            table {
                font-size: 10px; /* Police réduite pour impression */
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
        <div class="table-container">
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
        </div>

        <!-- Matières Littéraires -->
        <div class="section-title">Matières Littéraires</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th>Notes</th>
                        <th>Coefficient</th>
                        <th>Notes Pondérées</th>
                        <th>Appréciation</th>
                        <th>Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Français</td>
                        <td>14</td>
                        <td>4</td>
                        <td>56</td>
                        <td>Bien</td>
                        <td>vccb</td>
                    </tr>
                    <tr>
                        <td>Histoire</td>
                        <td>9</td>
                        <td>3</td>
                        <td>45</td>
                        <td>Très Bien</td>
                        <td>sfsd</td>
                    </tr>
                    <tr>
                        <td>Philosophie</td>
                        <td>8</td>
                        <td>2</td>
                        <td>24</td>
                        <td>Passable</td>
                        <td>xccxc</td>
                    </tr>
                   
                   
                </tbody>
                <tr>
                    <td colspan="2" class="fusion">Total des Matières Littéraires</td>
                    <td>9</td>
                    <td>125</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="1">Moyenne :</td>
                    <td colspan="1">13.9</td>
                    <td colspan="2">Meilleure Moyenne :</td>
                    <td colspan="1">16</td>
                    <td>Rang :</td>
                    
                </tr>
            </table>
            
        </div>

        <!-- Matières Scientifiques -->
        <div class="section-title">Matières Scientifiques</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th>Notes</th>
                        <th>Coefficient</th>
                        <th>Notes Pondérées</th>
                        <th>Appréciation</th>
                        <th>Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mathématiques</td>
                        <td>9</td>
                        <td>4</td>
                        <td>72</td>
                        <td>Excellent</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Physique</td>
                        <td>7</td>
                        <td>3</td>
                        <td>42</td>
                        <td>Bien</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Chimie</td>
                        <td>6</td>
                        <td>2</td>
                        <td>24</td>
                        <td>Passable</td>
                        <td></td>
                    </tr>
                   
                    <tr>
                        <td colspan="2" class="fusion">Total des Matières Littéraires</td>
                        <td>9</td>
                        <td>125</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="1">Moyenne :</td>
                        <td colspan="1">13.9</td>
                        <td colspan="2">Meilleure Moyenne :</td>
                        <td colspan="1">16</td>
                        <td>Rang :</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Disciplines Sportives et Complémentaires -->
        <div class="section-title">Disciplines Sportives et Complémentaires</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th>Notes</th>
                        <th>Coefficient</th>
                        <th>Notes Pondérées</th>
                        <th>Appréciation</th>
                        <th>Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>DISCIPLINES PHYSIQUES ET SPORTIVES</td>
                        <td>14</td>
                        <td>2</td>
                        <td>72</td>
                        <td>Excellent</td>
                        <td></td>
                    </tr>
 
                    <tr>
                        <td colspan="2" class="fusion">Total des Matières Littéraires</td>
                        <td>9</td>
                        <td>125</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="1">Moyenne :</td>
                        <td colspan="1">13.9</td>
                        <td colspan="2">Meilleure Moyenne :</td>
                        <td colspan="1">16</td>
                        <td>Rang :</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bilan Trimestriel -->
        <div class="section-title">Bilan Trimestriel</div>
        <div class="table-container">
            <table>
                <tbody>
                    <tr>
                        <td colspan="2"><strong>Total Coefficient :</strong> 20</td>
                        <td colspan="2"><strong>Total Notes Pondérées :</strong> 295</td>
                    </tr>
                    <tr>
                        <td><strong>Moyenne sur 20 :</strong> 14.75</td>
                        <td><strong>Retrait des Points :</strong> 0</td>
                        <td colspan="2"><strong>Moyenne Définitive :</strong> 14.75</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Heures d'Absence :</strong> 0</td>
                        <td colspan="2"><strong>Absences Non Justifiées :</strong> 0</td>
                    </tr>
                </tbody>
                <tr>
                    <td colspan="2"><strong>Total Coefficient :</strong> 20</td>
                    <td colspan="2"><strong>Total Notes Pondérées :</strong> 295</td>
                </tr>
                <tr>
                    <td><strong>Moyenne sur 20 :</strong> 14.75</td>
                    <td><strong>Retrait des Points :</strong> 0</td>
                    <td colspan="2"><strong>Moyenne Définitive :</strong> 14.75</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Heures d'Absence :</strong> 0</td>
                    <td colspan="2"><strong>Absences Non Justifiées :</strong> 0</td>
                </tr>
            </table>
        </div>
        <!-- Signature et appréciation -->
        <div class="signature-section">
            <div>
                <strong>Appréciation du Conseil :</strong>


                <p style="margin-top: 70px;">Excellent trimestre. Continuez ainsi.</p>
            </div>
            <div style="position: absolute; margin-left: 400px; margin-top:-125px;">
                <strong>Le Professeur :</strong>
                  

                <p style="margin-top: 70px;">Georges Bailly BENAO</p>
            </div>
        </div>
    </div>
</body>
</html>
