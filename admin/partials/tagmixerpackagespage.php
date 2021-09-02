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

  if ($_GET['action'] == 'update'){

  if($_GET['deletepackagekey'] == 'No (default)'){

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
  } elseif($_GET['deletepackagekey'] == 'Yes - Be sure before you do this'){
    //get all the posts
    $thePackages = get_posts( array('post_type' => 'tagmixerpackage', 'numberposts' => 3000) );

    //get the current unique package key
    $strNeedle = explode(' / ', $_GET['existingmixers']);

    //loop through and find the post that contains this key and delete
    foreach($thePackages as $expkey){
      $strLoc = strpos($expkey->post_content, $strNeedle[1]);

      //check if this is the post
      if($strLoc !== false){
        wp_delete_post($expkey->ID, true);
      }
    }

  }


} elseif($_GET['action'] == 'gettherules'){
  //the user is trying to GET the rules for a current package, maybe to edit them

  //if the user is trying to SET DATA do this
  if ($_POST['action'] == 'settherules'){

            //get all the posts
            $thePackages = get_posts( array('post_type' => 'tagmixerpackage', 'numberposts' => 3000) );

            //get the current unique package key
            $strCurPackage = $_POST['postupdater'];
        
            //loop through and find the post that contains this key and delete
            foreach($thePackages as $expkey){
              $strLoc = strpos($expkey->post_content, $strCurPackage);
        
              //check if this is the post
              if($strLoc !== false){
                $strGetMetaData = update_post_meta($expkey->ID, 'curpackagerules', $_POST['thepackagesettings']);
                $strGetMetaData = get_post_meta($expkey->ID, 'curpackagerules', true);
              }
            }

  } else {

        //get all the posts
        $thePackages = get_posts( array('post_type' => 'tagmixerpackage', 'numberposts' => 3000) );

        //get the current unique package key
        $strNeedle = explode(' / ', $_GET['packagerulestoedit']);
    
        //loop through and find the post that contains this key and delete
        foreach($thePackages as $expkey){
          $strLoc = strpos($expkey->post_content, $strNeedle[1]);
    
          //check if this is the post
          if($strLoc !== false){
            $strGetMetaData = get_post_meta($expkey->ID, 'curpackagerules', true);
          }
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


//change which collapse is open based on action
$expand1 = '';
$expand2 = '';
$expand3 = '';
if ($_GET['action'] == ''){
    $expand1 = 'show';
} elseif($_GET['action'] == 'update'){
    $expand2 = 'show';
} elseif($_GET['action'] == 'gettherules'){
  $expand3 = 'show';
}


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


<script>

function addtheitem(){
  //add user selected items to our package set we are modifying
  var e = document.getElementById('itemtoadd');

  //alert(e.value);

  //determine what the user is doing and add the proper code
  if (e.value == 'Change Font Size'){
    //change the font size rule
    document.getElementById('thepackagesettings').value = document.getElementById('thepackagesettings').value + '\n' + "document.getElementById('" + document.getElementById('elementidtochange').value + "').style.fontSize = '" + document.getElementById('newidvalue').value + "';";
  } else if (e.value == 'Change Font Color'){
    //change the font color
    document.getElementById('thepackagesettings').value = document.getElementById('thepackagesettings').value + '\n' + "document.getElementById('" + document.getElementById('elementidtochange').value + "').style.color = '" + document.getElementById('newidvalue').value + "';";
  } else if (e.value == 'Change Background Color'){
    //change the background color
    document.getElementById('thepackagesettings').value = document.getElementById('thepackagesettings').value + '\n' + "document.getElementById('" + document.getElementById('elementidtochange').value + "').style.background = '" + document.getElementById('newidvalue').value + "';"; 
  } else if (e.value == 'Change Opacity'){
    //change the opacity
    document.getElementById('thepackagesettings').value = document.getElementById('thepackagesettings').value + '\n' + "document.getElementById('" + document.getElementById('elementidtochange').value + "').style.opacity = '" + document.getElementById('newidvalue').value + "';";
    //create a fallback for internet explorer as well
    var intIEValue = document.getElementById('newidvalue').value;
    intIEValue = intIEValue.replace('0.', '');
    intIEValue += '0';
    /*
      Above code removes the decimal and add a 0 for the IE Fallback
    */
    document.getElementById('thepackagesettings').value = document.getElementById('thepackagesettings').value + '\n' + "document.getElementById('" + document.getElementById('elementidtochange').value + "').style.filter = 'alpha(opacity=" + intIEValue + ")';";
  }

}

</script>


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

    <div id="collapseOne" class="collapse <?php echo($expand1); ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
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
    <div id="collapseTwo" class="collapse <?php echo($expand2); ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
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
            <hr>
            <div class="form-group">
                <label for="deletepackagekey"><strong>DELETE THIS PACKAGE? (this cannot be undone)</strong></label>
                <select class="form-control" name="deletepackagekey" id="deletepackagekey">
                <option>No (default)</option>
                <option>Yes - Be sure before you do this</option>
                </select>
            </div>
            <hr>
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
    <div id="collapseThree" class="collapse <?php echo($expand3); ?>" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
      Use the form below to start setting up the rules for your new Tag Mixer package. You can select from the item list of pre-defined items to help you automatically write rules. Alternatively, you can enter or write your own rules manually in the text fields and save them to the database as well. Everything is outputted as JAVASCRIPT and will only work as such. Any other code will be ignored or not work properly.<br><hr>


        <form action="" method="get">
        <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
        <input type="hidden" value="gettherules" name="action" />
        <div class="form-group">
                <label for="packagerulestoedit">Select Package to Load Rules From...</label>
                <select class="form-control" name="packagerulestoedit" id="packagerulestoedit">
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
            <button type="submit" class="btn btn-warning">Load In Package Rules</button>
        </form>

        <hr>
            Helpful Tools<br>
            Color Selector for Changes: <input type="color" id="theselector" name="theselector" value="#fff">
            <br><br>
            New Color Hex value: <p id="thecolor" style="font-size:20px;"></p>
        <hr>

        <script>
          //create a function to watch the color selector and output the change
          document.getElementById("theselector").onchange = function(){
            document.getElementById("thecolor").textContent = "";
            document.getElementById("thecolor").textContent += this.value;
          }
        </script>

        <form action="" method="post">
        <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
        <input type="hidden" value="settherules" name="action" />
        <input type="hidden" value="<?php echo($strNeedle[1]); ?>" name="postupdater" />
          <div class="form-group">
            <label for="itemtoadd">I Want to...</label>
            <select class="form-control" id="itemtoadd" name="itemtoadd">
            <option>Change Image</option>
            <option>Change Font Size</option>
            <option>Change Font Color</option>
            <option>Change Background Color</option>
            <option>Change Opacity</option>
            <option>Replace Words with Another Word</option>
            <option>Change Link (HREF) Locations</option>
            </select>
          </div>
          <div class="form-group">
            <label for="elementidtochange">ID of Element to Modify</label>
            <input type="text" class="form-control" id="elementidtochange" name="elementidtochange">
          </div>
          <div class="form-group">
            <label for="newidvalue">New Value to Change To</label>
            <input type="text" class="form-control" id="newidvalue" name="newidvalue">
          </div>
          <button type="button" onclick="addtheitem()" class="btn btn-secondary btn-lg">Add Rule to Tag Mixer Package</button>
          <hr><br>
          <div class="form-group">
            <p style="font-weight:bold;font-size:20px;">Package Being Edited: <?php echo($_GET['packagerulestoedit']); ?></p>
            <label for="thepackagesettings">Package Settings and Rules</label>
            <textarea class="form-control" id="thepackagesettings" name="thepackagesettings" rows="10"><?php echo($strGetMetaData); ?></textarea>
          </div><br><br>
          <button type="submit" class="btn btn-primary">Save Package Settings</button>
      </form>

      </div>
    </div>
  </div>
</div>
