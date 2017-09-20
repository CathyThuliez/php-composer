<?php
//  début de traitement de données
require('vendor/autoload.php');
require('prezlist-connect.php');


$sql = "SELECT * FROM veille";

// Envoi de la requête et récupération du résultat
$stmt = $conn->query($sql);
// fin de traitement de données

// début d'affichage de données
require('header.php');
?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div>
        <a class="btn btn-primary" href="prezlist-insert-html.php">Ajouter une nouvelle présentation</a>
      </div><br />

      <div class="count">
        Nombre de lignes : <?= $stmt->rowCount() ?>
      </div><br />

      <table class="table table-striped table-hover">
        <tr>
          <th>id</th>
          <th>titre</th>
          <th>auteur</th>
          <th>date</th>
          <th>durée</th>
        </tr>
      <?php
      while ($row = $stmt->fetch()) {
        echo "<tr>\n";

        echo "<td>" . $row['id'] . "</td>\n";
        echo "<td>" . $row['title'] . "</td>\n";
        echo "<td>" . $row['author'] . "</td>\n";
        echo "<td>" . $row['date'] . "</td>\n";
        echo "<td>" . $row['duration'] . "</td>\n";
        echo "<td>\n";
        echo "<a class=\"btn btn-success\" href=\"prezlist-update-html.php?id=" . $row['id'] . "\">éditer</a>\n";
        echo "<a class=\"btn btn-danger\" href=\"prezlist-delete-html.php?id=" . $row['id'] . "\" onclick=\"return window.confirm(&quot;Voulez vraiment supprimer cet élément ?&quot;);\">supprimer</a>\n";
        echo "</td>\n";

        echo "</tr>\n";
      }
      ?>
      </table>
    </div><!-- /.col-xs-12 -->
  </div><!-- /.row -->
</div><!-- /.container -->
<?php
require('footer.php');
