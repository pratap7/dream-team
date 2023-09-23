<?php 
  require_once "TeamController.php";

  $team = new TeamsController;
  $team->getDreamTeam();

  $players = $team->dreamTeam;
  $captains = $team->dreamCaptains;
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <title>Shuffle the Game</title>
</head>
<style>
  th {
    text-align: center;
    font-size: 30px;
  }
  td {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
  }
  table {
    font-family: "Lucida Console", "Courier New", monospace;
  }
  thead {
    background-color: silver;
  }
  body {
    background-image:url('images/bg-img.png')
  }
  button.btn {
    font-weight: bold;
  }

  sup {
    color:
  }
</style>
<body>

<div class="container mt-2">
  <div class="p-3 bg-success text-white rounded">
    <h1>Magic Team  | <button class="btn btn-danger"><?php echo $captains['captain'];?> <sup>captain</sup></button> <button class="btn btn-danger"><?php echo $captains['vice_captain'];?> <sup>vice captain</sup></button></h1>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-12">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Player</th>
        <!-- <th>Type</th> -->
      </tr>
    </thead>
    <tbody>
<?php
$i = 1; 
      foreach($players['WC'] as $player) { ?>
        <tr class='table-success'>
          <td><?php echo $i++;?></td>
          <td><button class="btn btn-primary"><?php echo $player;?></button></td>
          <!-- <?php //if($i == 2) echo "<td rowspan='".count($players['WC'])."'>Wicket Keepers</td>";?> -->
        </tr>
        <?php } 
      foreach($players['BAT'] as $player) { ?>
      <tr class='table-success'>
        <td><?php echo $i++;?></td>
        <td><button class="btn btn-warning"><?php echo $player;?></button></td>
      </tr>
      <?php } 
      foreach($players['ALL'] as $player) { ?>
        <tr class='table-success'>
          <td><?php echo $i++;?></td>
          <td><button class="btn btn-success"><?php echo $player;?></button></td>
        </tr>
        <?php } 
        foreach($players['BOWL'] as $player) { ?>
        <tr class='table-success'>
            <td><?php echo $i++;?></td>
            <td><button class="btn btn-info"><?php echo $player;?></button></td>
        </tr>
        <?php } ?>
    </tbody>
  </table>
    </div>
  </div>
</div>
</body>
</html>
