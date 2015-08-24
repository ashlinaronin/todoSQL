<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost:3306;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function test_getDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "1234-12-12";
            $task = new Task($description, $due_date);

            //Act
            $result = $task->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function test_setDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "1234-12-12";
            $task = new Task($description, $due_date);

            //Act
            $task->setDescription("Drink coffee.");
            $result = $task->getDescription();

            //Assert
            $this->assertEquals("Drink coffee.", $result);
        }

        function test_getId()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "2015-09-16";
            $task = new Task($description, $due_date);
            $task->save();

            //Act
            $result = $task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "2015-09-16";
            $id = 1;
            $task = new Task($description, $due_date, $id);

            //Act
            $task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($task, $result[0]);

        }

        function test_saveSetsId()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $task = new Task($description, $id);

            //Act
            $task->save();

            //Assert
            $this->assertEquals(true, is_numeric($task->getId()));
        }

        function test_getAll()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "2015-09-16";
            $id = 1;
            $task = new Task($description, $due_date, $id);
            $task->save();

            $description2 = "water the lawn";
            $due_date2 = "2015-09-16";
            $id2 = 2;
            $task2 = new Task($description2, $due_date2, $id2);
            $task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$task, $task2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "2015-09-16";
            $id = 1;
            $task = new Task($description, $due_date, $id);
            $task->save();

            $description2 = "Water the lawn";
            $due_date2 = "2015-09-16";
            $id2 = 2;
            $task2 = new Task($description2, $due_date2, $id2);
            $task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }



        function test_find()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "2015-09-16";
            $id = 1;
            $task = new Task($description, $due_date, $id);
            $task->save();

            $description2 = "Water the lawn";
            $due_date2 = "3015-09-16";
            $id2 = 2;
            $task2 = new Task($description2, $due_date2, $id2);
            $task2->save();

            //Act
            $result = Task::find($task->getId());

            //Assert
            $this->assertEquals($task, $result);
        }

        function test_update()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "1234-12-12";
            $id = 1;
            $task = new Task($description, $due_date, $id);
            $task->save();

            $new_description = "Clean the dog";

            //Act
            $task->update($new_description);

            //Assert
            $this->assertEquals("Clean the dog", $task->getDescription());
        }

        function test_deleteTask()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = "1234-12-12";
            $id = 1;
            $task = new Task($description, $due_date, $id);
            $task->save();

            $description2 = "Water the lawn";
            $due_date2 = "1234-12-12";
            $id2 = 2;
            $task2 = new Task($description2, $due_date2, $id2);
            $task2->save();

            //Act
            $task->delete();

            //Assert
            $this->assertEquals([$task2], Task::getAll());
        }

    }


?>
