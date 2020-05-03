<?php

include_once(__DIR__ . "/classes/Classroom.php");
include_once(__DIR__ . "/classes/Db.php");

if (!empty($_POST["keyword"])) :
    $keyword = $_POST["keyword"] . "%";
    $classrooms = Classroom::completeSearch($keyword);
    if (!empty($classrooms)) : ?>
        <ul class="class-list" style="list-style:none; padding: 0px; width: 171px;">
            <?php foreach ($classrooms as $classroom) : ?>
                <li style="background-color:white; border:solid black 1px" onClick="selectClass('<?php echo $classroom->name; ?>');"><?php echo $classroom->name; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>