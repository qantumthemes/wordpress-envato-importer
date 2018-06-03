<?php

/* = Main function that creates the options page
==========================================================================*/




    ?>
    <h1>Import Items</h1>
    <div class="wrap">
        
      

        <div style="border-top:1px solid #dfdfdf; padding-top:30px;">
            <div id="qtenvatoimporter">
                <input type="text" name="btimporter_url" id="BPIurl" />
                <select name="marketplace" id="marketplace">
                    <option value="themeforest">themeforest</option>
                    <option value="codecanyon">codecanyon</option>
                    <option value="videohive">videohive</option>
                    <option value="audiojungle">audiojungle</option>
                    <option value="graphicriver">graphicriver</option>
                    <option value="photodune">photodune</option>
                    <option value="themeforest">themeforest</option>
                    <option value="3docean">3docean</option>
                    <option value="activeden">activeden</option>
                </select>
                <a href="#" class="button button-primary" id="BPIsubmit">Start</a>
            </div>
            <div id="finalresult">
            </div>
            <div id="qwResponse">
            </div>
            <div class="actions-box">
                <p>
                    <hr /><br />                       
                    <a href="#" class="button button-red" id="togglePerfAct">Stop Process</a>
                    <a href="#" class="button button-grey" id="resetAction">Reset and abort</a>
                </p>
            </div> 
            <h2>Instructions</h2>
            <ol>
                <li>Pick an item link, a user link or a collection link (<a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202821260-What-are-Public-Collections-">How to make collections</a>)</li>
                <li>Copy the link</li>
                <li>Paste it here and clean the GET vars (all from ? til end of url)</li>
                <li>In case of profile url, select the marketplace</li>
                <li>Paste it here</li>
                <li>Click start</li>
                <li>Choose what to import or import all. Reimporting items already in the database will result in updating featured image item detail, like ratings and price.</li>
            </ol>


            <a href="http://www.qantumthemes.com/" target="_blank" class="qw_logo">
            <img src="<?php echo plugins_url( 'qantum-logo-web.png', __FILE__ ); ?>" />
            </a>
        </div>
        <br>
   
    </div> <!-- wrap close -->
    <?php 

