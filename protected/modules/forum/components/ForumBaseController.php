<?php
/**
 * This is the base controller for any forum related contollers.
 * Its main reason for existance is it will populate the forumuser table, and
 * set the user state "forumuser_id" to a correct value.
 * All controllers in the foum module must extend from this base class.
 */
class ForumBaseController extends MainController
{
    public $Title = "Форум";
}