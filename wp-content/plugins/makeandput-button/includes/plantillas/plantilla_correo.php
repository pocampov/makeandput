<?php
echo '<div class="modal">
  <h1>Contact Form</h1>
  <form>
    <div class="form-group">
      <label for="sender-email">Sender Email:</label>
      <input type="email" class="form-control" id="sender-email" placeholder="Enter sender email">
    </div>
    <div class="form-group">
      <label for="recipient-email">Recipient Email:</label>
      <input type="email" class="form-control" id="recipient-email" placeholder="Enter recipient email">
    </div>
    <div class="form-group">
      <label for="subject">Subject:</label>
      <input type="text" class="form-control" id="subject" placeholder="Enter subject">
    </div>
    <div class="form-group">
      <label for="message">Message:</label>
      <textarea class="form-control" id="message" rows="5"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>';
