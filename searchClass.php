<?php

spl_autoload_register();
session_start();

if (!empty($_POST["keyword"])) :
    $keyword = $_POST["keyword"] . "%";
    $classrooms = classes\Buddy\Classroom::completeSearch($keyword);
    if (!empty($classrooms)) : ?>
        <ul class="class-list" style="list-style:none; padding: 0px; width: 185.5px;">
            <?php foreach ($classrooms as $classroom) : ?>
                <li style="background-color:white; border:solid #848484 0.5px; padding: 5px; border-top:none;" onClick="selectClass('<?php echo $classroom->name; ?>');"><?php echo $classroom->name; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>