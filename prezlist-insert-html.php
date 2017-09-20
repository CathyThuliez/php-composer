<?php

require('vendor/autoload.php');
require('prezlist-connect.php');

$informations = [];
$errors = [];
$title = '';
$author = '';
$date = null;
$duration = null;

if ($_POST) {
  $valid = true;

  if (isset($_POST['title']) && !empty(trim($_POST['title']))) {
    $title = $_POST['title'];
  } else {
    $valid = false;
    $errors['title'] = 'Vous devez spécifier un titre';
  }

  if (isset($_POST['author']) && !empty(trim($_POST['author']))) {
    $author = $_POST['author'];
  } else {
    $valid = false;
    $errors['author'] = 'Vous devez spécifier un auteur';
  }

  if (isset($_POST['date']) && !empty(trim($_POST['date']))) {
    $date = $_POST['date'];
  }

  if (isset($_POST['duration']) && !empty(trim($_POST['duration']))) {
    $duration = $_POST['duration'];
  }

  if ($valid) {
    try {
      $count = $conn->insert('veille', [
        'title' => $title,
        'author' => $author,
        'date' => $date,
        'duration' => $duration,
      ]);

      $lastInsertId = $conn->lastInsertId();
    } catch (Exception $e) {
      // echo $e->getMessage();
      header('Location: error500.html', true, 302);
      exit();
    }

    $informations['form'] = $count . ' présentation créée (id : ' . $lastInsertId . ')';
  }
}

require('header.php');
?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div>
        <a class="btn btn-primary" href="prezlist-select-html.php">Retour à la liste des présentations</a>
      </div>

      <h1>Création d'une présentation</h1>

      <div>
        <?php
        if (isset($informations['form'])) {
          echo $informations['form'];
        }
        ?>
      </div>

      <form action="<?= basename(__FILE__) ?>" method="post">

        <div>
          <?php
          if (isset($errors['title'])) {
            echo $errors['title'];
          }
          ?>
        </div>
        <input type="text" name="title" value="<?= htmlentities($title) ?>" placeholder="titre" /> *<br />

        <input type="text" name="author" value="<?= htmlentities($author) ?>" placeholder="auteur" /> *<br />

        <input type="date" name="date" value="<?= htmlentities($date) ?>" placeholder="date" /><br />

        <input type="number" name="duration" value="<?= htmlentities($duration) ?>" placeholder="durée" /><br />

        <input type="submit" value="valider" class="btn btn-success" /><br />

      </form>
    </div><!-- /.col-xs-12 -->
  </div><!-- /.row -->
</div><!-- /.container -->
<?php
require('footer.php');
