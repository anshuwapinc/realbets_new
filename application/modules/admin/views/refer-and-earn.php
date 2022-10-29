<style>
    /* body{
        background:#22222e;
        font-family: 'Montserrat', sans-serif;
   
    } */
    .back {
        width: 16px;
        position: absolute;
        z-index: 3;
        top: 0;
        padding-top: 16px;
        padding-left: 20px;
    }

    p {

        font-size: 16px;
        color: #000;
        text-align: center;
    }

    .line {
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(161, 158, 158, 0.205);
    }

    .side {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .sides {
        background: #33335940;
        margin-right: 1px;
        width: 48vw;
    }

    .sides p {
        font-size: 12px;
        padding: 10px;
    }

    .side p,
    .qr p {
        font-size: 12px;
    }

    .qr {
        padding: 20px 0;
        background: #33335940;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

    }

    .qr img {
        margin-bottom: 10px;
    }

    .submit {
        width: 202px;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        ;
        font-size: 12px;
        background: #178fff;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.3);
        padding: 10px;
        outline: none;
        border: none;
        border-radius: 6px;
        color: black;
        font-weight: 500;
        cursor: pointer;
        transition: 300ms ease-in all;
        margin-bottom: 15px;
    }

    .submit:hover {
        background: #0058aa;
        color: white;
    }

    p {
        padding: 5px;
    }
</style>
<main id="main" class="main-content">
<div class="right_col" role="main">
    <div class="fullrow tile_count" style="margin-top:25px;">
        <div class="side">



            <div class="sides">
                <center>
                    <a href="<?php echo base_url('refered-users')?>"><p> <?php echo $totalReffered ?></p></a>
                </center>
                <center>
                <a href="<?php echo base_url('refered-users')?>"><p>No of Registered user</p></a>
                </center>
            </div>
            <div class="sides">
                <center>
                    <p><?php echo $totaldeposit_request ?></p>
                </center>
                <center>
                    <p> No of Deposit</p>
                </center>
            </div>
        </div>
        <div class="side" style="background:#33335940;padding:10px;">

            <p>Reference code</p>
            <p><?php echo $referral_code ?></p>
        </div>
        <center class="qr">
        <p id="copy-url-text">https://realbets.in/sign-up?refer=<?php echo $referral_code ?></p>   
        <p>Reference QR Code</p>
            <img src="https://chart.apis.google.com/chart?cht=qr&amp;chs=200x200&amp;chl=https://realbets.in/sign-up?refer=<?php echo $referral_code ?>" alt="">
            <button id="copy-url-btn" onclick="copytoclipBoard()" class="submit">Copy Reference Link</button>    
        </center>
        <div class="side" style="background:#33335940;padding: 10px;">

            <p>Today's Bonus</p>
            <p>0 </p>
        </div>
        <center class="qr">
            <button class="submit">Bonus History</button>



        </center>
    </div>
</div>
</main>
<script type="text/javascript">
    function copytoclipBoard() {
        // Create a "hidden" input
        var aux = document.createElement("input");

        // Assign it the value of the specified element
        aux.setAttribute("value", document.getElementById("copy-url-text").innerText);

        // Append it to the body
        document.body.appendChild(aux);

        // Highlight its content
        aux.select();

        // Copy the highlighted text
        document.execCommand("copy");

        // Remove it from the body
        document.body.removeChild(aux);

    }
</script>