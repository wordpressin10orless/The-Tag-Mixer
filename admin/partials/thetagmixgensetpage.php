<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    partials/thetagmixgensetpage
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<?php

$mainswitch = get_option( 'tagmixmasterswitch' );

if ($mainswitch == ''){
    //switch is off so set some classes and text
    $jumboSet = 'alert alert-danger';
    $loadingcircles = '';
} else {
    $jumboSet = 'alert alert-success';
    $loadingcircles = '
    <br><br><div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>    <div class="spinner-border text-success" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    ';
}

?>

<h1 style="font-family: 'Oswald', sans-serif;">The Tag Mixer General Settings</h1>
<hr>
<p class="alert alert-secondary" style="font-family: 'Oswald', sans-serif;font-size:24px;color:#000;">The tag mixer allows you to control page elements by ID and change their features based on incoming queries which can be either GET or POST. To activate this plugin select the master switch to on and make sure you have set up at least 1 package set. Not sure what to do? <a href="#">Click here to find out.</a></p>
<br><br>

<center>
<div class="jumbotron jumbotron-fluid <?php echo($jumboSet); ?>" style="width:60%;text-align:center;">
  <div class="container">
    <h1 class="display-4" style="color:#000;">The Master Switch</h1>
    <p style="color:#000;font-size:26px;">
        <?php 
            if($mainswitch == ''){
                //tell them its off
                echo('The Tag Mixer is currently turned off, and so it is NOT changing any page elements. Turn it on, will ya?');
            } else {
                echo('The Tag Mixer is currently turned ON, and so it is changing your desired elements based on your pre-set packages. In other words, its party time.');
            }
        ?>
    </p>
    <form action="options.php" method="post">
        <?php
        settings_fields('tagmixersgenset');
        do_settings_sections('tagmixersgenset');
        ?>
        <input name="tagmixmasterswitch" <?php if($mainswitch == ''){}else{echo('checked');} ?> type="checkbox" data-toggle="toggle" data-on="Party <br>Time" data-off="Not Party Time" data-onstyle="success" data-offstyle="danger">
        <br><br>
        <input type="submit" style="font-size:28px;" class="btn btn-success" value="Save Changes" />
    </form>
    <?php echo($loadingcircles); ?>
  </div>
</div>
</center>

<hr>

<center>

<div class="jumbotron" style="max-width:60%;">
  <h2 style="font-family: 'Oswald', sans-serif;">Tag Mixer Source Keys</h2>
  <p style="font-size:16px;">This section allows you to setup "Tag Mixer Source Keys", which can be selected when you are setting up your package sets. When assigning a package set with a source key, that package will only edit page elements if it has a corrosponding tagmixkey= settings matching the source key ID parameter.</p><br>

  <form>
    <div class="form-group">
        <label for="existingsourcekeys">Source Keys</label>
        <select class="form-control" id="existingsourcekeys" name="existingsourcekeys">
        <?php
            //gather the existing source keys
            $sourceKeys = get_posts( array('post_type' => 'tagmixersourcekeys', 'numberposts' => 3000) );

            //check to see how many we have
            if(count($sourceKeys) == 0){
                //we have no posts
                echo ('<option>No Source Keys Created</options>');
            }
        ?>
        </select><br>
        <input type="submit" class="btn btn-warning btn-lg" value="Delete This Source Key" />
    </div>
  </form>
  <br>
  <p style="font-size:26px;">OR</p>
  <br>
  <p style="font-size:24px;font-family: 'Oswald', sans-serif;">Add a new Tag Mixer Source Key</p>
    
    <form action="" method="post" class="alert alert-dark">
        <div class="form-group">
            <label for="tagmixsourcename">Source Name</label>
            <input type="text" class="form-control" name="tagmixsourcename" id="tagmixsourcename" placeholder="Facebook"><br>
            <label for="tagmixsourcekey">Source Key</label>
            <input type="text" class="form-control" name="tagmixsourcekey" id="tagmixsourcekey" placeholder="fbname"><br>
            <input type="submit" class="btn btn-success btn-lg" value="ADD This Source Key" />
        </div>
    </form>

</div>

</center>