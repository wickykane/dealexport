<p>
Bonjour <?php echo $user->first_name ?> <?php echo $user->last_name ?>,
</p>
<p>Votre compte est activé.</p>
<p>Merci de cliquer sur le lien pour accéder au site internet: <a href="<?php echo get_author_posts_url($user->ID);?>"><?php echo get_author_posts_url($user->ID);?></a></p>
<p>
L'équipe DealExport
</p>