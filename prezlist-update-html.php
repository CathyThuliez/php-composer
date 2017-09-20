<?php

require('vendor/autoload.php');
require('prezlist-connect.php');

$informations = [];
$errors = [];
$title = '';
$author = '';
$date = null;
$duration = null;

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
  $id = $_GET['id'];

  $todo = $conn->fetchAssoc('SELECT * FROM veille WHERE id = ?', [$id]);

  if (!$todo) {
    header('Location: prezlist-select-html.php', true, 302);
    exit();
  }

  $title = $veille['title'];
  $author = $veille['author'];
  $date = $veille['date'];
  $duration = $veille['duration'];
} else {
  header('Location: prezlist-select-html.php', true, 302);
  exit();
}

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
    $errors['title'] = 'Vous devez spécifier un auteur';
  }

if (isset($_POST['date']) && !empty(trim($_POST['date']))) {
    $date = $_POST['date'];
  } else {
    $date = null;
  }

if (isset($_POST['duration']) && !empty(trim($_POST['duration']))) {
    $duration = $_POST['duration'];
  } else {
    $date = null;
  }

if ($valid) {
    try {
      $count = $conn->update('veille', [
        'title' => $title,
        'author' => $author,
        'date' => $date,
        'duration' => $duration,
      ], ['id' => $id]);

      $lastInsertId = $conn->lastInsertId();
    } catch (Exception $e) {
      // echo $e->getMessage();
      header('Location: error500.html', true, 302);
      exit();
    }

    $informations['form'] = 'présentation modifiée';
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

      <h1>Modification d'une présentation</h1>

      <div>
        <?php
        if (isset($informations['form'])) {
          echo $informations['form'];
        }
        ?>
      </div>

      <form action="<?= basename(__FILE__) ?>?id=<?= $id ?>" method="post">

        <div>
          <?php
          if (isset($errors['title'])) {
            echo $errors['title'];
          }
          ?>
        </div>
        <input type="text" name="title" value="<?= htmlentities($title) ?>" placeholder="titre" /> *<br />

        <input type="text" name="author" value="<?= htmlentities($author) ?>" placeholder="author" /><br />

        <input type="datetime" name="date" value="<?= htmlentities($date) ?>" placeholder="date limite" /><br />

        <input type="number" name="duration" value="<?= htmlentities($duration) ?>" placeholder="durée" /><br />


        <input type="submit" value="valider" class="btn btn-success" /><br />

      </form>
    </div><!-- /.col-xs-12 -->
  </div><!-- /.row -->
</div><!-- /.container -->
<?php
require('footer.php');
