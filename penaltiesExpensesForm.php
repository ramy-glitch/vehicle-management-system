<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penalties and Fines Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
    <h2>Penalties and Fines Form</h2>
    <form action="/submit_penalties_fines" method="post">
        <label for="driver_id">Driver's Licence number:</label>   
        <input type="number" id="driver_id" name="driver_id" required>

        <label for="vehicle_LP">Vehicle Licence Plate number:</label>   
        <input type="vehicle_LP" id="vehicle_LP" name="vehicle_LP" required>

        <label for="penalty_type">Penalty Type:</label>
        <input type="text" id="penalty_type" name="penalty_type" required>

        <label for="penalty_date">Penalty Date:</label>
        <input type="date" id="penalty_date" name="penalty_date" required>

        <label for="penalty_amount">Penalty Amount:</label>
        <input type="number" id="penalty_amount" name="penalty_amount" min="0" required>



        <input type="submit" value="Submit">
        <input type="button" value="Back" onclick="window.location.href='penaltiesExpensestList.html'">
    </form>
    </div>
</body>
</html>

