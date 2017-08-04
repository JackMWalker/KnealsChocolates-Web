		<section id="sub-content-boxes" class="parties-container">
			<section class="left-boxes" id="top-left-box">
			<h3>Availability</h3>
				<p>If you've decided a chocolate party is for you, fill in the simple request form on the right and we will get back in touch ASAP to book you in.
					<br/><br/>Before you fill in the form, remember to check availability <a href="/page/news_events/">here</a> on our 
					calendar and check whether you live in our service region below.</p>
			</section>
			
			<section class="left-boxes" id="bottom-left-box">
				<h3>Location</h3>
				  <p>Kneals Chocolate Parties are only available in and around the Birmingham area at the moment.<br />Here you can check if your postcode is within our service region.</p><br/>
				  <section id="enter_postcode"><label class="postcode_label" for="Postcode"><p>Enter the first part of your postcode (eg. WS1 or AB12):</p></label><input maxlength="4" id="postcode" name="postcode" onkeydown="if (event.keyCode == 32) {return false }if (event.keyCode == 13) {document.getElementById('postcode_search').click()}"/>
				  <button id="postcode_search" type="button" onClick="javascript:check_postcode();">Submit</button></section>
				  <section id="result"></section>
			</section>
			
			<section class="right-box animated bounceInRight">
				<form id="party_request_form" name="party_request_form" action="" method="">
					<fieldset>
						<legend>Party Request Form</legend>		
							<p class="form-item">
							<label for="name">Name/Company:</label><input size="30" type="text" name="name" id="name" /><span class="required">*</span>
							<span class="hidden" id="name_error">This field is required.</span>
							</p>
							
							<p class="form-item">
							<label for="phone">Phone No.:</label><input size="30" onkeypress="return isNumberKey(event)" maxlength="11" type="text" name="phone" id="phone"/><span class="required">*</span>
							<span class="hidden" id="phone_error">This field is required.</span>
							</p>
							
							<p class="form-item">
							<label for="address1">Address Line 1:</label><input size="30" type="text" name="address1" id="address1" /><span class="required">*</span>
							<span class="hidden" id="address1_error">This field is required.</span>
							</p>
							
							<p class="form-item">
							<label for="address2">Address Line 2:</label><input size="30" type="text" name="address2" id="address2" />
							</p>
							
							<p class="form-item">
							<label for="email">Email:</label><input size="30" placeholder="johndoe@example.com" type="email" name="email" id="email"/><span class="required">*</span>
							<span class="hidden" id="email_error">This field is required.</span>
							</p>
							
							<p class="form-item">
							<label for="city">City/Town:</label><input size="30" type="text" name="city" id="city" /><span class="required">*</span>
							<span class="hidden" id="city_error">This field is required.</span>
							</p>
							
							<p class="form-item">
							<label for="form_postcode">Postcode:</label><input type="text" size="15" maxlength="8" name="form_postcode" id="form_postcode"/><span class="required">*</span>
							<span class="hidden" id="postcode_error">This field is required.</span>
							</p>
							
							<p  class="form-item" style="height:48px;">
							<label for="doe">Date of Event: <font size="3px">(dd/mm/yyyy)</font></label><input type="date" name="doe" id="doe"/><span class="required">*</span>
							<span class="hidden" id="date_error">This field is required.</span>
							</p>
							
							
							<p class="form-item">
							<label class="long_label" for="Comments">Please leave any extra comments we may need to consider:</label><textarea id="comments" name="comments" rows="4" cols="50" placeholder="leave comments here..."></textarea>
							</p>
							<p id="req-field-desc"><span class="required">*</span> indicates a required field</p>
							<button class="sbmt_button" name="submit" type="button" onClick="javascript:submit_form();">Submit</button>
					</fieldset>

				</form>
			</section>
		</section>	

