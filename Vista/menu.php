<header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php">NUTRILIFE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">

            <?php
                if(isset($menu_permiso)):
                foreach($menu_permiso as $menuper): ?>
              <?php foreach($menus as $menu): ?>
                  <?php if($menu['name']==$menuper) :?>
                    <li class="nav-item ">
                      <a class="nav-link" href='<?php echo $menu['href'] ?>'><?php echo $menu['text'] ?></a>
                    </li>
                  <?php break; endif; ?>
              <?php endforeach; ?>
            <?php endforeach; endif ?>

          </ul>
          
        </div>
      </nav>
    </header>
