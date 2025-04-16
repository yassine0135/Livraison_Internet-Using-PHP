<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Colis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
  color: #0066cc;
  text-align: center;
}
h3 {
  color: #0066cc;
  
}

        .progress-container {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            position: relative;
        }

        .progress-container::before {
            content: '';
            background-color: #e0e0e0;
            height: 5px;
            width: 100%;
            position: absolute;
            top: 50%;
            left: 0;
            z-index: 1;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            width: 25%;
            text-align: center;
        }

        .progress-step::before {
            content: '✔';
            display: block;
            margin: 0 auto;
            background-color: #4CAF50;
            color: white;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            z-index: 3;
        }

        .progress-step span {
            display: block;
            margin-top: 10px;
        }

        .step-completed {
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-container {
            margin-top: 20px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Suivez votre colis 007438157458</h2>
    <div class="tracking-info">
      <h3 class="text-center mb-3">Tracking Information</h3>
      <div class="row">
        <div class="col-md-6">
          <p><strong>Reference number:</strong> 007438157458</p>
        </div>
        <div class="col-md-6">
          <p><strong>Expéditeur:</strong>       reda, boukri, hay salam, 0659547234, 92150 </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p><strong>Distinataire:</strong> Yassne Maizi </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p><strong>Status:</strong> Delivry </p>
        </div>
      </div>
    </div>

    <div class="progress-container">
        <div class="progress-step">
            <div class="step-completed"></div>
            <span>Article accepté</span>
        </div>
        <div class="progress-step">
            <div class="step-completed"></div>
            <span>Expédité</span>
        </div>
        <div class="progress-step">
            <div class="step-completed"></div>
            <span>En-transit</span>
        </div>
        <div class="progress-step">
            <div class="step-completed"></div>
            <span>Delivry</span>
        </div>
        
    </div>

    <table>
        <thead>
            <tr>
                <th>Date et heure</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>27/09/2024 11:12</td>
                <td>Delivry</td>
            </tr>
            <tr>
                <td>27/09/2024 07:26</td>
                <td>en-transit(ksar el kebir)</td>
            </tr>
            <tr>
                <td>27/09/2024 07:21</td>
                <td>en-transit(tanger)</td>
            </tr>
            <tr>
                <td>26/09/2024 07:30</td>
                <td>Expédité</td>
            </tr>
            <tr>
                <td>26/09/2024 02:49</td>
                <td>Article accépter</td>
            </tr>
            
        </tbody>
    </table>

   
</body>
</html>