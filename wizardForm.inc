<!-- WIZARD -->
<div id='wizard' style='display: none;'>
    <div id="startQuestion" class="qn 1st">
        <a href="#"><img src="img/icons/exit.png" alt="close" class="wizardClose"></a>
        <h3>Welcome to the Wizard!</h3>
        <h4 class="wizText">Would you like to answer a few questions that will help fill in your
            budget?</h4>

        <button type="button" id="startClose">No thanks, get me out of here!</button>
        <button type="button" id="startStart">Yes lets answer some questions!</button>
    </div>

    <div id="wizFormBody" class="qn 2nd">
        <a href="#"><img src="img/icons/exit.png" alt="close" class="wizardClose"></a>
        <div class="questionNum">Question:<br/><span id="actualQuestion"></span></div>
        <h3>Wizard Questions</h3>
        <div id="wizInfo" class="wizText"></div>
    </div>

    <div id="wizSubmitForm" class="qn 3rd">
        <a href="#"><img src="img/icons/exit.png" alt="close" class="wizardClose"></a>
        <h3>Wizard Complete</h3>
        <div class="wizText">You have successfully completed the wizard questions. Click submit to show the items that most
            apply to you in the budget planner.<br/> Hit back if you would like to re-answer some questions.</div>

        <input type="submit" id="wizSubmit" class="nextStyle" value="Submit">
    </div>

    <button type="button" id="back" style="display: none;">Back</button>
    <button type="button" id="wizNo" class="wizButtons" style="display: none;">No</button>
    <button type="button" id="wizYes" class="wizButtons" style="display: none;">Yes</button>
</div>
