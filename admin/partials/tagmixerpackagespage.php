<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *   Tag Mixer Packages 
 */
?>

<?php


//IF the user is updating a package Do THIS
if (isset($_GET['action'])){
  //user is updating a tag mixer package
  $thePackages = get_posts( array('post_type' => 'tagmixerpackage', 'numberposts' => 3000) );

  $thePackageKey = explode(' / ', $_GET['existingmixers']);

  foreach ($thePackages as $epackage){
    //check for same unique key as user selected package

      if ($epackage->post_content == $thePackageKey[1]){

      if ($_GET['renametagmixpackage'] !== ''){
        //user has a new NAME so update the NAME
        $data = array(
          'ID' => $epackage->ID,
          'post_title' => $_GET['renametagmixpackage'],
        );

        //update the post name
        wp_update_post( $data );
      }

      //update the meta data if the user wants to change the source
      if ($_GET['newsourcekey'] !== ''){
        //update the meta
        update_post_meta($epackage->ID, 'thesourcekey', $_GET['newsourcekey']);
      }
    }
  }
}


//check to see if we need to add the NEW tag mixer package
if( isset($_GET['tagmixerpackagename']) ){
  //we need to add the new source key post
  $data = array(
      'post_title' => $_GET['tagmixerpackagename'],
      'post_content' => $_GET['tagmixerpackagekey'],
      'post_category' => '',
      'tags_input' => '',
      'post_status' => 'publish',
      'post_type' => 'tagmixerpackage',
  );

  //add the new source key
  $result = wp_insert_post( $data );

  //ADD SOME POST META TO THIS NEW TAG MIXER PACKAGE
  if ( $result && ! is_wp_error( $result ) ) {
      add_post_meta( $result, 'thesourcekey',  $_GET['sourcekeys']);
  }

}


//generate a random key for a new package
$length = 12;

//generate a random key
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomizer = '';
for ($i = 0; $i < $length; $i++) {
    $randomizer .= $characters[rand(0, $charactersLength - 1)];
}

//get the PAGE
$thecurpage = $_GET['page'];

?>

<style>

.card{
    border: none;
    padding: 0px;
    margin: 0px;
    max-width: 100%;
}

.accordion{
    width: 80%;
    max-width: 100%;
    margin: 0px auto;
}

#wpwrap{
    background-color: #000;
}

</style>

<!-- Includes -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<h1 style="text-align:center;color:#fff;font-family: 'Oswald', sans-serif;">Tag Mixer Packages</h1>
<br>
<center><p style="font-family: 'Oswald', sans-serif;font-size:24px;text-align:center;color:#fff;max-width:60%;">Use the forms below to add or edit all of your existing packages in Tag Mixer. Anything you set in here will become immediately active in your site so make sure you check all your changes.</p></center>

<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Add a new Tag Mixer Package
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
      Create a tag mixer package below by setting a new name class, and optionally selecting a source ID that you set in your main settings. After the package is created, you will be taken to a section to start adding commands to it.<br><br><br>
        <form method="get" action="">
            <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
            <div class="form-group">
                <label for="tagmixerpackagename">Tag Mixer Package Name</label>
                <input type="text" class="form-control" name="tagmixerpackagename" id="tagmixerpackagename" placeholder="The Home Depot">
            </div>
            <div class="form-group">
                <label for="tagmixerpackagekey">Tag Mixer Package Key</label>
                <input type="text" class="form-control" name="tagmixerpackagekey" id="tagmixerpackagekey" value="<?php echo($randomizer); ?>">
            </div>
            <div class="form-group">
                <label for="sourcekeys">Predefined Traffic Sources</label>
                <select class="form-control" name="sourcekeys" id="sourcekeys">
                <option>All Sources (default)</option>
                <?php
                    //gather the existing source keys
                    $sourceKeys = get_posts( array('post_type' => 'tagmixersourcekeys', 'numberposts' => 3000) );

                    //check to see how many we have
                    if(count($sourceKeys) == 0){
                        
                    } else {
                        //loop through the source keys and ouput
                        foreach($sourceKeys as $skey){
                            echo('<option>' . $skey->post_title . ' / ' . $skey->post_content . '</option>');
                        }
                    }
                ?>
                </select>
            </div>
            <button type="submit" class="btn btn-lg btn-success">Save The New Tag Mixer Package</button>
        </form>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Edit an existing Tag Mixer Package
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        
      <form method="get" action="">
            <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
            <input type="hidden" value="update" name="action" />
            <div class="form-group">
                <label for="existingmixers">Existing Tag Mixer Packages</label>
                <select class="form-control" name="existingmixers" id="existingmixers">
                <?php
                    //gather the existing source keys
                    $tagmixerpackages = get_posts( array('post_type' => 'tagmixerpackage', 'numberposts' => 3000) );

                    //check to see how many we have
                    if(count($tagmixerpackages) == 0){
                        echo('<option>No Tag Mixer Packages</option>');
                    } else {
                        //loop through the source keys and ouput
                        foreach($tagmixerpackages as $tagkey){
                            echo('<option>' . $tagkey->post_title . ' / ' . $tagkey->post_content . ' / ' . get_post_meta($tagkey->ID, 'thesourcekey', true) . '</option>');
                        }
                    }
                ?>
                </select>
            </div>
            
            <hr>

            <div class="form-group">
                <label for="renametagmixpackage">Tag Mixer Package Key</label>
                <input type="text" class="form-control" name="renametagmixpackage" id="renametagmixpackage" placeholder="New Package Name..." >
            </div>

            <div class="form-group">
                <label for="newsourcekey">Change Traffic Source</label>
                <select class="form-control" name="newsourcekey" id="newsourcekey">
                <option>All Sources (default)</option>
                <?php
                    //gather the existing source keys
                    $sourceKeys = get_posts( array('post_type' => 'tagmixersourcekeys', 'numberposts' => 3000) );

                    //check to see how many we have
                    if(count($sourceKeys) == 0){
                        
                    } else {
                        //loop through the source keys and ouput
                        foreach($sourceKeys as $skey){
                            echo('<option>' . $skey->post_title . ' / ' . $skey->post_content . '</option>');
                        }
                    }
                ?>
                </select>
            </div>
            <button type="submit" class="btn btn-lg btn-success">Update this Tag Mixer Package</button>
        </form>

      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Current Tag Mixer Package Settings
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
