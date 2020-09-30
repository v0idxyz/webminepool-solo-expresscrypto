<?php

  include_once("handler.php");

  include_once("parts/head.php");

  include_once("parts/menu.php");

?>

  <div class="heading">

    <h1>Solo mining is much easier than you thought</h1>

    <p class="lead">Utilize your processor, grahpics cards, or your cell phone to obtain bitcoin.<br> Direct payments straight to your <a href="http://faucethub.io/r/3110154">FaucetHub</a> account.<br>It's that simple.</p>

    <a class="btn btn-default" href="#working"  >Start Mining</a>

  </div>

  <main role="main" id="working" class="container">

    <div class="inner-container">

      <div class="row">

        <h2>Getting started:</h2>

        <h4>All you need to start mining are these two things:</h4>

        <ul>

          <li>

            A bitcoin wallet linked to your <a href="http://faucethub.io/r/3110154">FaucetHub</a> account

          </li>

          <li>

            Mining software

          </li>

        </ul>

        <p>

          Do you not have a bitcoin wallet or address? Don't fret!

          Bitcoin.org can help you choose one that suits you best.

          Link your new address to your <a href="http://faucethub.io/r/3110154">FaucetHub</a> account (explained <a href="https://faucethub.io/help/45">here</a>).

          </p>

        <form class="main-address" id="loginForm">

          <div class="form-group">

            <input class="form-control" id="btc-address" type="text" placeholder="Input your BTC address here"><button class="btn btn-success btn-green">Submit</button>

          </div>

        </form>

        <p>

          Note: all your earnings will go to this address. If you want to change it, just input another address.

          

        </p>      

      </div>

      <div class="row">

        <h4>Mining software:</h4>

        <p>First, download miner which will automatically detect your hardware (CPU or GPU).

        A dedicated GPU can mine anywhere from 150-1,000 hashes per second, depending on your cards.

        A processor can mine anywhere from 10-300 hashes a second depending its performance and clock rate.

        GPU mining is a lot more profitable. Find your estimated hashrate(s) for your parts

        <a href="http://monerobenchmarks.info/">here</a>. 

        </p>

        

        <!--<div class="col-md-4 offset-md-4">

          <div class="card">

            <div class="card-body">

              <h5 class="card-title">WMP Stak based miner</h5>

              <p class="card-text">Recommended by our service</p>

              <p><a href="https://mega.nz/#!efRlzQSB!1ROgnkUuY4RpWeFFz6Ju2wV8C_gunFtKAp1_vsQ8MtE" class="card-link">Download miner</a>

              <a href="/config?rig=unified" class="card-link">Personal config</a></p>

            </div>

          </div>

        </div>-->

        <div class="col-md-6 offset-md-3">

           

          <img src="dist/img/screen1.jpg" class="screen1">

          

        </div>

        <p style="width: 100%; text-align: center;">

          <a class="btn btn-success btn-green" style="margin: 0; width: 80%; text-decoration: none;" href="<?= $config->miner_url ?>">Download latest version.</a>

        </p>

        

        

      </div>

      <div class="row">

        <h4>How to use these miners:</h4>

          <ul>

          <li>

            Download the miner.

          </li>

          <li>

            Unzip and run it.

          </li>

          <li>

            Input your BTC address which is linked with FaucetHub and press "Start".

          </li>

          <li>

            Enjoy your profits!

          </li>

        </ul>

        

      </div>



      </div>

    </div>

  </main>

<?php

  include_once("parts/modal.php");

  include_once("parts/js.php");

?>

</body>

</html>

