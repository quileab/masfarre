<?php
// read folder names inside /img/events using php
$dir = 'img/events/';
$files = scandir($dir);
// remove . and .. from array
$files = array_diff($files, array('.', '..'));

// create array of objects with attributes name=folder name, image=first image inside folder, subtitle=first line of description.txt inside the folder, description=second to end of description.txt inside the folder
$events = array();
foreach ($files as $file) {
  // get all images inside folder
  $images = scandir($dir . $file);

  $events[] = (object) [
    'name' => $file,
    'image' => $dir . $file . '/' . $images[2],
  ];
  if(file_exists($dir . $file . '/description.txt')){
    $events[count($events) - 1]->subtitle = explode("\n", file_get_contents($dir . $file . '/description.txt'))[0];
    $events[count($events) - 1]->description = implode("\n", array_slice(explode("\n", file_get_contents($dir . $file . '/description.txt')), 1));
  } else {
    $events[count($events) - 1]->subtitle = '';
    $events[count($events) - 1]->description = '';
  }

}

foreach ($events as $event) {
echo
<<<EVENT
    <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s">
      <div class="list_inner">
      <img src="{$event->image}" alt="" />
      
      <div class="overlay"></div>
      <div class="details">
      <span>{$event->name}</span>
      <h3>{$event->subtitle}</h3>
      </div>
      <a class="grax_tm_full_link zoom" href="{$event->image}"></a>
      </div>
    </li>
EVENT;
}
