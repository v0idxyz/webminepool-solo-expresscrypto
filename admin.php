<?php
  include_once("handler.php");
  include_once("parts/head.php");
  include_once("parts/menu.php");
?>
    <main role="main" id="working" class="container account-container">
      <div class="inner-container">
        <?php if($app->admin){echo  $app->draw_users_table();} ?>
      </div>
    </main>
    <?php
      include_once("parts/modal.php");
      include_once("parts/js.php");
    ?>
    
    <p class="powered-by">powered by <a href="https://webminepool.com">webminepool.com</a></p>
  </body>
</html>