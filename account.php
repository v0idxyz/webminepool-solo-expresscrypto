<?php
  include_once("handler.php");
  include_once("parts/head.php");
  include_once("parts/menu.php");
?>
    <main role="main" id="working" class="container account-container">
      <div class="inner-container">
        <div class="row" style="<?php if( !isset($_COOKIE['btc_address'])){echo "display: none !important;";}?>">
          <div class="col-md-6">
            <h4>Pool stats:</h4>
            <h5>Pool balance: <?= round($app->faucet_balance) ?> sat</h5>
            <h5>Pool rate: <span id="rate"><?= round($app->rate) ?></span> sat for 1M hashes</h5>
            <h5>Mininal withdraw: <span id="minimal_payout"><?= round($config->minimal_payout) ?></span> sat </h5>
            <h5>Referral payments: <span id="rererral"><?= round($config->referral) ?></span>% </h5>
          </div>
          <div class="col-md-6">
            <h4>Your stats:</h4>
            <h5>Address: <span style="font-size: 1rem;"><?= $_COOKIE['btc_address'] ?></span></h5>
            <h5>Balance (hashes): <span id="balance_hashes"><?= $app->balance ?></span></h5>
            <h5>Balance (satoshi): <span id="balance_satoshi"><?= $app->balance/1000000*$app->rate ?></span></h5>
            <form id="withdrawForm" style="<?php if( $config->manual_payouts==1){echo "display: none !important;";}?>">
              <input type="hidden" name="balance_satoshi" value="<?= $app->balance/1000000*$app->rate ?>">
              <input type="hidden" name="balance_hashes" value="<?= $app->balance?>">
              <input type="hidden" name="address" id="btc_address" value="<?= $_COOKIE['btc_address'] ?>">
              <button class="btn btn-success btn-green" style="width: 90%; display: block; margin: 0 auto;">Withdraw</button>
            </form>
            <p style="<?php if( $config->manual_payouts==0){echo "display: none !important;";}?>; color: #34de5b;"><b>Payouts are manually processed by admin.</b></p>
          </div>
          <p class="reflink"><b>Your refferal link:</b> http://<?= $_SERVER['SERVER_NAME'] ?>/?r=<?= $_COOKIE['btc_address']?></p>
        </div>
        <div class="row" style="<?php if( isset($_COOKIE['btc_address'])){echo "display: none !important;";}?>">
          <div class="col-md-8 offset-2">   
          <h1 style="text-align: center;">Login please</h1>
          <form class="main-address" action="handler.php" method="POST" id="loginForm">
            <div class="form-group">
              <input type="hidden" id="redirect" name="redirect" value=1>
              <input class="form-control" id="btc-address" type="text" placeholder="Input your BTC address here"><button class="btn btn-success btn-green">Login</button>
            </div>
          </form>
          </div> 
        </div>
      </div>
    </main>
    <?php
      include_once("parts/modal.php");
      include_once("parts/js.php");
    ?>
    <p class="powered-by">powered by <a href="https://webminepool.com">webminepool.com</a></p>
  </body>
</html>
