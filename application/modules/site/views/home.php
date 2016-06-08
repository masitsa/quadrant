
	<?php
        echo $this->load->view("home/slider", '', TRUE);
    ?>
    <!-- Content -->
    <div id="content"> 
    <?php
        echo $this->load->view("home/about", '', TRUE);
        echo $this->load->view("home/services", '', TRUE);
        //echo $this->load->view("home/blog", '', TRUE);
        //echo $this->load->view("home/testimonials", '', TRUE);
        //echo $this->load->view("home/specialists", '', TRUE);
        //echo $this->load->view("home/partners", '', TRUE);
    ?>
    </div>
