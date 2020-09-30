<nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbartop" aria-controls="navbartop " aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbartop">
        
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="navbar-brand" href="<?= $config->site_url ?>"><img class="logo" height="40" src="https://webminepool.com/img/logo.png">WebMineSOLO</a>
          </li>
        </ul>
          <div class="nav-bar-right">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-download"></i> Downloads</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="<?= $config->miner_url ?>">Miner</a>
                  </div>
                </li>
                 
                <li class="nav-item">
                  <a class="nav-link" href="account"><i class="fa fa-user"></i> Account</a>
                </li>
            </ul>
            
          </div>
      </div>
    </nav>