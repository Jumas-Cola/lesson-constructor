<?php
    require_once("configDB.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script src="html5sortable.js"></script>

    <title>Конструктор уроков</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  </head>
  <body>




    <section class="container m-3 ml-auto mr-auto">

      <?php
        $result = $pdo->query('SELECT stage_table_name FROM stages');
        $stages = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
          $stages[] = $row['stage_table_name'];
        }

        if (isset($_GET['stage']) && isset($_GET['id'])) {
          $table = htmlspecialchars($_GET['stage']);
          if (in_array($table, $stages)){
            $id = $_GET['id'];
            $qu = "SELECT * FROM ".$table." WHERE id=:id";
            $stmt = $pdo->prepare($qu);
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<section class="container">
                <h2 class="mb-4">'.$row['name'].'</h2>
                <section>'.$row['description'].'</section>
            </section>';
          }
      }
      ?>

    </section>


    <section class="container">
      <hr class="featurette-divider m-5">
    </section>


    <footer class="container pb-5">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>© 2017-2018 Some Company, Inc.</p>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
