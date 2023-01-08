<?php
/*
Plugin Name: Nimbus Nordic Fjernadgang
Description: Tildel Nimbus Nordic adgang til at yde support på din hjemmeside
Author: Nimbus Nordic IT
*/

function nimbus_nordic_remote_access_menu() {
  add_submenu_page(
    'options-general.php', // Parent menu slug
    'Nimbus Nordic Remote Access', // Page title
    'Opret Adgang', // Menu title
    'manage_options', // Capability
    'nimbus-nordic-remote-access', // Menu slug
    'nimbus_nordic_remote_access_page' // Callback function to render the page
  );
}
add_action( 'admin_menu', 'nimbus_nordic_remote_access_menu' );

function nimbus_nordic_remote_access_page() {
  if ( !current_user_can( 'manage_options' ) ) {
    wp_die( 'You do not have sufficient permissions to access this page.' );
  }
  ?>
  <h1>Nimbus Nordic fjern adgang</h1>
  <p>Her kan du give Nimbus Nordic fjern adgang til dit Wordpres site for at yde support, vi tilgår ikke siden medmindre der er en fejl der skal fikses, eller du beder om support fra os. Vi behandler din data jf. vores Persondata politik og vores Fjernadgangs politik. Du kan læse vores politik <a href="www.nimbusnordic.dk/fjernadgang">her</a>.</p>
  <form method="post" action="">
    <input type="checkbox" name="agree-to-policies" id="agree-to-policies">
    <label for="agree-to-policies">Jeg har læst og bekræfter Persondata politik og vores Fjernadgangs politik og giver Nimbus Nordic fjern adgang til dette websted</label><br>
    <input type="submit" name="create-remote-access" value="Opret Fjernadgang">
  </form>
  <?php
  if ( isset( $_POST['create-remote-access'] ) ) {
    if ( !isset( $_POST['agree-to-policies'] ) || !$_POST['agree-to-policies'] ) {
      echo '<p>Du skal bekræfte Persondata politik og vores Fjernadgangs politik for at give Nimbus Nordic fjern adgang.</p>';
    } else {
      $username = 'Nimbus Nordic';
      $password = 'Ymw.1144*'; // Change this to the desired password
      $user_id = wp_create_user( $username, $password);
    }
  }
}

function nimbus_nordic_remote_access_deletion_menu() {
        add_submenu_page(
          'options-general.php', // Parent menu slug
          'Nimbus Nordic Remote Access Deletion', // Page title
          'Nimbus Nordic Fjernadgang', // Menu title
          'manage_options', // Capability
          'nimbus-nordic-remote-access-deletion', // Menu slug
          'nimbus_nordic_remote_access_deletion_page' // Callback function to render the page
        );
      }
      add_action( 'admin_menu', 'nimbus_nordic_remote_access_deletion_menu' );
      
      function nimbus_nordic_remote_access_deletion_page() {
        if ( !current_user_can( 'manage_options' ) ) {
          wp_die( 'You do not have sufficient permissions to access this page.' );
        }
        ?>
        <h1>Nimbus Nordic Fjernadgang</h1>
        <form method="post" action="">
          <input type="checkbox" name="agree-to-termination" id="agree-to-termination">
          <label for="agree-to-termination">Jeg bekræfter at jeg sletter adgang for Nimbus Nordic, og at jeg hermed opsiger support adgang fra Nimbus Nordic. Såfremt du ønsker support i fremtiden af Nimbus Nordic skal der betales et gebyr på 2999 kr</label><br>
          <input type="submit" name="delete-remote-access" value="Slet Fjernadgang">
        </form>
        <?php
        if ( isset( $_POST['delete-remote-access'] ) ) {
          if ( !isset( $_POST['agree-to-termination'] ) || !$_POST['agree-to-termination'] ) {
            echo '<p style="font-size: 18px; color: red;">Tryk på checkboxen for at slette bruger</p>';
          } else {
            $username = 'Nimbus Nordic';
            $user = get_user_by( 'login', $username );
            if ( $user ) {
              wp_delete_user( $user->ID );
              // Create log and send email with log attached
            } else {
              echo '<p>Brugeren "Nimbus Nordic" eksisterer ikke.</p>';
            }
          }
        }
      }
