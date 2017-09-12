<!--CONTACT DIALOG-->
<?php
  require_once 'core/init.php';

 ?>
<div style="font-family: 'Trirong', serif;" class="modal fade" id="contact" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" action="msg.php">
          <div class="modal-header">
            <h4 style="font-family: 'Slabo 27px', serif;" class="text-center">Contact Us</h4>
          </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="name" class="col-sm-2">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="contact-name"
                  placeholder="Full Name" name="name" value="" />
                </div>
              </div>
              <div class="form-group">
                <label for="number" class="col-sm-2">Phone</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="contact-name"
                  placeholder="Phone Number" name="number" value="" />
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-2">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="contact-email"
                  placeholder="example@domain.com" name="email" value="" />
                </div>
              </div>
              <div class="form-group">
                <label for="caption" class="col-sm-2">Caption</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="contact-caption"
                  placeholder="Title of message" name="caption" value="" />
                </div>
              </div>
              <div class="form-group">
                <label for="message" class="col-sm-2">Message</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="4"  name="message" value="" placeholder="Your message..."></textarea>
                </div>
              </div>
              <p>
                For general inquiries, please email us:
                <strong>journal@cepaJournal.com</strong>
              </p>
              <p>
                or please call: <strong>+2348131976306</strong>
              </p>
            </div>
            <div class="modal-footer">
              <a class="btn btn-default outline" data-dismiss="modal">Cancel</a>
              <button type="submit" class="btn btn-primary outline">Submit</button>
            </div>
      </form>
        </div>
      </div>
    </div>
