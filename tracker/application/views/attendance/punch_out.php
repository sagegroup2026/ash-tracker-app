<style>
.punch-main{ 
    height:90%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.punch-card{
    width:100%;
    max-width:420px;
    background:#fff;
    border-radius:24px;
    padding:35px 28px;
    text-align:center;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    position:relative;
    overflow:hidden;
}

.punch-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:8px;
    background:#00799E;
}

.punch-img{
    width:120px;
    margin:auto;
    margin-bottom:20px;
}

.punch-img img{
    width:100%;
}

.punch-title{
    font-size:28px;
    font-weight:700;
    color:#0d1b2a;
    margin-bottom:10px;
}

.punch-subtitle{
    font-size:15px;
    color:#6c757d;
    line-height:1.7;
    margin-bottom:30px;
}

.highlight-text{
    color:#00799E;
    font-weight:600;
}

.punch-btn{
    width:100%;
    background:#00799E;
    border:none;
    color:#fff;
    padding:15px 20px;
    border-radius:16px;
    font-size:17px;
    font-weight:700;
    transition:0.3s ease;
    position:relative;
    overflow:hidden;

    /* GLOW EFFECT */
    box-shadow:
        0 0 0 rgba(0,121,158,0.6),
        0 0 25px rgba(0,121,158,0.45);

    animation:pulseGlow 1.8s infinite;
}

/* SHINE EFFECT */
.punch-btn::before{
    content:'';
    position:absolute;
    top:0;
    left:-120%;
    width:60%;
    height:100%;
    background:rgba(255,255,255,0.35);
    transform:skewX(-25deg);
    animation:shine 2.5s infinite;
}

.punch-btn:hover{
    background:#006684;
    transform:translateY(-3px) scale(1.02);

    box-shadow:
        0 0 35px rgba(0,121,158,0.65),
        0 10px 30px rgba(0,121,158,0.35);
}

/* PULSE */
@keyframes pulseGlow{
    0%{
        box-shadow:
            0 0 0 0 rgba(0,121,158,0.6),
            0 0 20px rgba(0,121,158,0.35);
    }

    70%{
        box-shadow:
            0 0 0 14px rgba(0,121,158,0),
            0 0 35px rgba(0,121,158,0.55);
    }

    100%{
        box-shadow:
            0 0 0 0 rgba(0,121,158,0),
            0 0 20px rgba(0,121,158,0.35);
    }
}

/* SHINE ANIMATION */
@keyframes shine{
    0%{
        left:-120%;
    }

    100%{
        left:130%;
    }
}
.punch-icon{
    margin-right:8px;
}

.bottom-text{
    margin-top:22px;
    font-size:13px;
    color:#9aa5b1;
}

</style>
<div class="punch-main">

    <div class="punch-card">

        <div class="punch-img">
            <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png" alt="Punch Out">
        </div>

        <h2 class="punch-title">
            Good Bye 
            <i class="bi bi-box-arrow-right" style="color:#00799E;"></i>
        </h2>

        <p class="punch-subtitle">
            You are about to <span class="highlight-text">Punch Out</span><br>
            Mark your exit attendance before leaving for the day.
        </p>

        <form method="POST" action="<?= base_url('save-punch-out') ?>">

            <!-- Location -->
            <input type="hidden" name="location" id="location">

            <button type="submit" class="punch-btn">
                <i class="fa fa-right-from-bracket punch-icon"></i>
                Punch Out
            </button>

        </form>

        <div class="bottom-text">
            Thank you for your work today. Have a productive day ahead.
        </div>

    </div>

</div>
<script src="<?php echo base_url();?>assets/scripts/fetch_location.js"></script>