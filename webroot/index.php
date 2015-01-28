<?php
require __DIR__.'/config_with_app.php';
//linkhandling
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
//choose theme for the site
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
//configure the navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
//welcomepage
$app->router->add('',function() use ($app){
 $app->theme->setTitle('Magnus Hansson');
 //content for home
 $content  =$app->fileContent->get('me.md');
 $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 //byline for home
 $byline = $app->fileContent->get('byline.md');
 $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
//adding view for homepage
 $app->views->add('me/page',[
 	'title' => "Om mig",
 	'content'=> $content,
 	'byline' => $byline,
 	]);
});
//assignments page
$app->router->add('redovisning', function() use($app){
 $app->theme->setTitle('Redovisning');
 //content for assignments page
 $content = $app->fileContent->get('redovisning.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

 $byline = $app->fileContent->get('byline.md');
 $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
 $app->views->add('me/page',[
 	'title' => "Redovisning",
 	'content'=> $content,
 	'byline' => $byline,]);

});
//source code page
$app->router->add('source', function() use ($app){
	$app->theme->setTitle("Källkod");
	$app->theme->addStylesheet('css/source.css');
 	
 	$source= new \Mos\Source\CSource([
 		'secure_dir' =>'..',
 		'base_dir' =>'..',
 		'add_ignore' =>['.htaccess'],
 		]);

 	$app->views->add('me/source',[
 		'content' => $source->View(),
 		]);
});

$app->router->handle();
$app->theme->render();



?>