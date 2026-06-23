<link href="https://admin.apollosage.in/tracker-test/assets/stylesheet/common/form.css" rel="stylesheet">
<div class="main-div">
    <div class="profile-wrapper">
        <h4 class="profile-title">Events</h4>
        <?php if(!empty($events)){
             foreach($events as $e){ 
             if(!empty($e->image)){ ?>
    
            <!-- WITH IMAGE -->
            <div class="image-full-card">
    
                <!-- Top Full Image -->
                <div class="full-event-image">
    
                    <img src="<?= base_url('uploads/events/'.$e->image); ?>" alt="Event Image">
    
                    <div class="event-overlay"></div>
    
                    <div class="event-days-box">
                        <?php
                        $days = floor((strtotime($e->date) - time()) / (60 * 60 * 24));
                        ?>
                        
                        <h3>
                            <?= ($days >= 0) ? $days . ' Days' : 'Completed'; ?> 
                        </h3>
                        <span>Days</span>
                    </div>
    
                    <div class="event-badge">
                        <?= date('d M', strtotime($e->event_date)); ?>
                        -
                        <?= date('d M', strtotime($e->end_date)); ?>
                    </div>
    
                </div>
    
                <!-- Bottom Details -->
                <div class="full-event-content">
    
                    <h4><?= $e->event_title; ?></h4>
                    <p>
                        <i class="bi bi-geo-alt"></i>
                        <?= $e->city_name; ?> (<?= $e->state_name; ?>)
                    </p>
    
                    <p>
                        <i class="bi bi-person"></i>
                        Organiser: <?= $e->agent_name; ?>
                    </p>
    
                    <a href="javascript:void(0)"
                       data-bs-toggle="modal"
                       data-bs-target="#eventModal<?= $e->id; ?>">
                        More Details
                    </a>
    
                </div>
    
            </div>
            <?php } else { ?>
            <!-- WITHOUT IMAGE -->
            <div class="up-event-room-card">
    
                <div class="up-event-room-left">
    
                    <div class="full-event-content">
    
                        <h4><?= $e->event_title; ?></h4>
                        <?php if (!empty($e->city_name)){?>
                        <p>
                            <i class="bi bi-geo-alt"></i>
                            <?= $e->city_name; ?> (<?= $e->state_name; ?>)
                        </p>
                        <?php } ?>
                         <p>
                            <i class="bi bi-calendar-event"></i>
                            <?= date('d M', strtotime($e->event_date)); ?>
                            -
                            <?= date('d M', strtotime($e->end_date)); ?>
                        </p>
                        <p>
                            <i class="bi bi-person"></i>
                            Organiser: <?= $e->agent_name; ?>
                        </p>
    
                        <a href="javascript:void(0)"
   data-bs-toggle="modal"
   data-bs-target="#eventModal<?= $e->id; ?>">
    More Details
</a>


    
                    </div>
    
                </div>
    
                <div class="up-event-room-date">
                <?php
                $today      = strtotime(date('Y-m-d'));
                $event_date = strtotime($e->event_date);
                $end_date   = strtotime($e->end_date);
                
                if ($today < $event_date) {
                
                    $days = floor(($event_date - $today) / (60 * 60 * 24));
                    echo '<h3>' . $days . ' <span>Days</span></h3>';
                
                } elseif ($today >= $event_date && $today <= $end_date) {
                
                    echo '<h3><span class="text-success">Started</span></h3>';
                
                } else {
                
                    echo '<h3><span class="text-danger">Ended</span></h3>';
                }
                ?>
                
                </div>
    
            </div>
            <div class="modal fade" id="eventModal<?= $e->id; ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content event-modal">

            <div class="modal-header border-0">
                <div>
                    <h3 class="event-title mt-2 mb-1">
                        <?= $e->event_title; ?>
                    </h3>

                    <p class="text-muted mb-0">
                        <i class="bi bi-calendar-event"></i>
                        <?= date('d M Y', strtotime($e->event_date)); ?>
                        -
                        <?= date('d M Y', strtotime($e->end_date)); ?>
                    </p>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div class="event-purpose-card">
                    <h6>
                        <i class="bi bi-bullseye"></i>
                        Event Purpose
                    </h6>

                    <p class="mb-0">
                        <?= !empty($e->event_purpose) ? nl2br($e->event_purpose) : 'N/A'; ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
            <?php }}} else { ?>
            <div class="no-events-found">
                Oops, No Events Found!
            </div>
            <?php }?>
    </div>
</div>
<style>
.no-events-found {
    text-align: center;
    color: red;
    font-weight: 700;
}
/* Full Image Card */
.image-full-card{
    margin-bottom: 18px;
    padding:0;
    overflow:hidden;
    border-radius:24px;
    background:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* Image */
.full-event-image{
    position:relative;
    height:220px;
    overflow:hidden;
}

.full-event-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.5s ease;
}

.image-full-card:hover .full-event-image img{
    transform:scale(1.05);
}

/* Overlay */
.event-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top,
    rgba(0,0,0,0.65),
    rgba(0,0,0,0.10));
}

/* Days Box */
.event-days-box{
    position:absolute;
    top:18px;
    right:18px;
    width:72px;
    height:82px;
    background:rgba(255,255,255,0.95);
    border-radius:18px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    z-index:2;
    box-shadow:0 5px 18px rgba(0,0,0,0.15);
}

.event-days-box h3{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#1c1c1c;
    line-height:1;
}

.event-days-box span{
    margin-top:5px;
    font-size:14px;
    color:#5f6885;
    font-weight:600;
}

/* Badge */
.event-badge{
    position:absolute;
    bottom:18px;
    left:18px;
    background:#ffffff;
    color:var(--blue);
    padding:7px 16px;
    border-radius:40px;
    font-size:13px;
    font-weight:600;
    z-index:2;
    box-shadow:0 5px 15px rgba(0,0,0,0.10);
}

/* Content */
.full-event-content{
    padding:22px;
}

.full-event-content h4{
    font-size:16px;
    font-weight:700;
    color:#1d1d1d;
    margin-bottom:14px;
}

.full-event-content p{
    margin-bottom:10px;
    color:#677089;
    font-size:15px;
    display:flex;
    align-items:center;
    gap:10px;
}

.full-event-content p i{
    color:var(--blue);
    width:18px;
}

.full-event-content a {
    text-decoration: underline;
    /* display: inline-flex; */
    /* align-items: center; */
    justify-content: center;
    /* margin-top: 12px; */
    /* background: var(--blue); */
    color: var(--blue);
    /* padding: 11px 22px; */
    /* border-radius: 12px; */
    /* text-decoration: none; */
    /* font-size: 14px; */
    font-weight: 600;
    transition: 0.3s ease;
}

.full-event-content a:hover{
    background:#0077e6;
    text-decoration:none;
    color:#fff;
}

/* Mobile */
@media(max-width:767px){

    .full-event-image{
        height:190px;
    }

    .event-days-box{
        width:62px;
        height:72px;
    }

    .event-days-box h3{
        font-size:20px;
    }

    .full-event-content{
        padding:18px;
    }

    .full-event-content h4{
        font-size:16px;
    }

    .full-event-content p{
        font-size:14px;
    }

}

/* Card */
.up-event-room-card{
    background:#fff;
    border-radius:22px;
    padding:18px;
    margin-bottom:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 6px 20px rgba(0,0,0,0.06);
    border:2px solid transparent;
    transition:0.3s ease;
    gap:15px;
}

.up-event-room-card:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

/* Left */
.up-event-room-left{
    display:flex;
    align-items:flex-start;
    gap:16px;
    flex:1;
}

/* Image */
.up-event-room-image{
    width:90px;
    height:90px;
    border-radius:18px;
    overflow:hidden;
    flex-shrink:0;
}

.up-event-room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* Content */
.up-event-room-content{
    flex:1;
}

.up-event-room-content .bagde{
    display:inline-block;
    background:#edf4ff;
    color:var(--blue);
    font-size:12px;
    font-weight:600;
    padding:5px 12px;
    border-radius:30px;
    margin-bottom:8px;
}

.up-event-room-content h4{
    font-size:18px;
    font-weight:700;
    color:#1f1f1f;
    margin-bottom:6px;
}

.up-event-room-content p{
    margin-bottom:4px;
    color:#6a7088;
    font-size:14px;
    line-height:1.4;
}

.up-event-room-content a{
    display:inline-block;
    margin-top:8px;
    color:var(--blue);
    font-size:14px;
    font-weight:600;
    text-decoration:none;
}

.up-event-room-content a:hover{
    text-decoration:underline;
}

/* Right Days Box */
.up-event-room-date{
    width:78px;
    min-width:78px;
    height:92px;
    border-radius:16px;
    background:#f7f9fc;
    border:1px solid #dbe1ef;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.up-event-room-date h3{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#1d1d1d;
    line-height:1;
}

.up-event-room-date span{
    margin-top:4px;
    font-size:14px;
    color:#68708d;
    font-weight:600;
}

/* Responsive */
@media(max-width:767px){

    .up-event-room-card{
        padding:15px;
        border-radius:18px;
    }

    .up-event-room-left{
        gap:12px;
    }

    .up-event-room-image{
        width:72px;
        height:72px;
        border-radius:14px;
    }

    .up-event-room-content h4{
        font-size:16px;
    }

    .up-event-room-content p{
        font-size:13px;
    }

    .up-event-room-date{
        width:65px;
        min-width:65px;
        height:78px;
    }

    .up-event-room-date h3{
        font-size:20px;
    }

}

/* Extra small mobile */
@media(max-width:575px){

    .up-event-room-card{
        align-items:flex-start;
    }

    .up-event-room-left{
        width:100%;
    }

    .up-event-room-date{
        width:60px;
        min-width:60px;
        height:72px;
    }

}

.event-modal{
    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.12);
}

.event-modal .modal-header{
    padding:20px;
    background:linear-gradient(135deg,#f8fafc,#ffffff);
}

.event-badge{
    display:inline-block;
    padding:6px 14px;
    background:#eef4ff;
    color:#2563eb;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.event-title{
    font-size:17px;
    font-weight:700;
    color:#111827;
}

.event-modal .modal-body{
    padding:25px;
}

.event-purpose-card{
    background:#f8fafc;
    border-radius:18px;
    padding:24px;
    border:1px solid #edf2f7;
}

.event-purpose-card h6{
    font-weight:700;
    margin-bottom:15px;
    color:#111827;
}

.event-purpose-card p{
    color:#6b7280;
    line-height:1.8;
}

.info-card{
    background:#fff;
    border:1px solid #eef2f7;
    border-radius:18px;
    padding:20px;
    display:flex;
    align-items:center;
    gap:15px;
    transition:.3s;
}

.info-card:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(0,0,0,.08);
}


.info-card small{
    color:#6b7280;
    display:block;
    margin-bottom:4px;
}

.info-card h5{
    margin:0;
    font-weight:700;
    color:#111827;
}

.modal-footer{
    padding:20px 30px 30px;
}

</style>