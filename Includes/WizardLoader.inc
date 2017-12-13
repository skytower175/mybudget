<?php
require_once 'Data.inc';
require_once 'BudgetItemLoader.inc';

class WizardQuestion
{
    public $id;

    /*
     *
     * @var BudgetItem[]
     */
    //public $items;

    public $question;

    /*
     *
     * @var int[]
     */
    public $itemIds;


    /*
    *
    * @var int[]
    */
    public $stepNum;

}

class WizardLoader
{
    public static function GetWizardItems()
    {
        $items = array();
        $queryResults = RunQuery('SELECT id, step_num, question FROM wizard_question ORDER BY step_num', array());
        foreach ($queryResults as $row){
            $item = new WizardQuestion();
            $item->id = $row['id'];
            $item->question = $row['question'];
            $item->stepNum = $row['step_num'];
            $query2 = RunQuery('SELECT item_id_str FROM wizard_link WHERE WIZARD_QUESTION like ?', array($item->id));
            $item->itemIds = array();
            foreach ($query2 as $row2){
                //array_push($item->items, BudgetItemLoader::GetSingleItem($row2['item_id_str']));
                array_push($item->itemIds, $row2['item_id_str']);
            }
            array_push($items, $item);
        }
        return $items;
    }
}

?>
