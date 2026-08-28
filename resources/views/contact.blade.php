@extends('layouts.app')

@section('title', 'Contact Us | Maha Construction')

@section('content')
<section class="section-pad" style="padding-top:60px;">
    <div class="container">
        <div style="margin-bottom:32px;">
            <span class="sec-tag">CONTACT CORE</span>
            <h1 class="sec-title">DISCUSS YOUR LAND</h1>
            <p class="sec-sub">Connect with our Nagercoil office to schedule site surveys, discuss custom construction plans, or get estimate timelines.</p>
        </div>

        <div class="guidebook-card-box contact-grid-box">
            <div>
                <div style="margin-bottom:24px;">
                    <div style="font-size:0.75rem;font-weight:800;color:var(--gold);margin-bottom:4px;">OFFICE ADDRESS</div>
                    <div style="font-size:0.95rem;color:#fff;line-height:1.6;">Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil</div>
                </div>
                <div style="margin-bottom:24px;">
                    <div style="font-size:0.75rem;font-weight:800;color:var(--gold);margin-bottom:4px;">DIAL PHONE</div>
                    <div style="font-size:0.95rem;color:#fff;"><a href="tel:+919488888758" style="color:var(--gold);font-weight:800;">+91 94888 88758</a></div>
                </div>
                <div style="margin-bottom:24px;">
                    <div style="font-size:0.75rem;font-weight:800;color:var(--gold);margin-bottom:4px;">EMAIL</div>
                    <div style="font-size:0.95rem;color:#fff;">Mahaconstructions2013@gmail.com</div>
                </div>
                <div style="margin-bottom:24px;">
                    <div style="font-size:0.75rem;font-weight:800;color:var(--gold);margin-bottom:4px;">BUSINESS HOURS</div>
                    <div style="font-size:0.95rem;color:#fff;">Monday - Saturday: 10:00 AM - 6:00 PM</div>
                </div>
                <a href="https://wa.me/919488888758?text=Hello%20Er.%20Maha%20Rajan" target="_blank" class="btn-whatsapp-outline">
                    <i class="fab fa-whatsapp" style="margin-right:6px;font-size:18px;"></i> WHATSAPP DIRECT
                </a>
            </div>

            <div>
                <div class="tab-toggle-group" style="margin-bottom:20px;">
                    <button class="tab-btn active">GENERAL INQUIRY</button>
                    <button class="tab-btn" data-open-quote>REQUEST DETAILED ESTIMATE BLUEPRINT</button>
                </div>

                <form id="contactFormCore" class="quote-form-grid">
                    <div class="form-field full-width">
                        <label>FULL NAME</label>
                        <input type="text" name="name" required placeholder="Enter your full name" class="input-dark">
                    </div>
                    <div class="form-field">
                        <label>EMAIL ADDRESS</label>
                        <input type="email" name="email" required placeholder="name@gmail.com" class="input-dark">
                    </div>
                    <div class="form-field">
                        <label>TELEPHONE</label>
                        <input type="tel" name="phone" placeholder="+91 94888 88758" class="input-dark">
                    </div>
                    <div class="form-field full-width">
                        <label>INQUIRY DETAIL</label>
                        <textarea name="message" rows="4" placeholder="Tell us about your plot size, location, or requirements..." class="input-dark"></textarea>
                    </div>
                    <div class="form-field full-width">
                        <button type="submit" class="btn-gold-submit"><i class="fas fa-paper-plane" style="margin-right:6px;"></i> LOG GENERAL INQUIRY</button>
                    </div>
                    <div id="contactSuccessCore" class="form-success-box" style="display:none;">
                        <i class="fas fa-circle-check" style="margin-right:6px;color:#25D366;"></i> General Inquiry Logged! We will contact you shortly.
                    </div>
                </form>
            </div>
        </div>

        <!-- Google Maps Embed -->
        <div style="margin-top:40px;border-radius:20px;overflow:hidden;border:1px solid var(--border-gold);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.4357492193587!2d77.4278453!3d8.1812836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b04f138865d4b53%3A0x6a0c5c360a0f9b33!2sNagercoil%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
@endsection
