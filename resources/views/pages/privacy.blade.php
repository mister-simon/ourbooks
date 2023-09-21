<?php

use function Laravel\Folio\{name};

name('privacy');

?>
<x-layouts.app title="Home" :hide-sidebar="Auth::guest()">
    @auth
        <x-app-card title="Build a New Shelf" class="card-bordered">
            <livewire:shelf-create />
        </x-app-card>
    @else
        <x-app-card class="card-bordered">

            <div class="prose max-w-screen-xl">
                <h1 class="text-center"><strong>OurBooks.top Privacy Policy</strong></h1>
                <p class="text-center">Effective date: 20th day of September, 2023
                </p>
                <p>
                    ourbooks.top (the "Site") is owned and operated by Simon Wheelwright. Simon Wheelwright is the data controller and can be contacted at: <br><br>ourbookstop-privacy@simons.bulc.club
                </p>
                <p><strong><u>Purpose</u></strong><br>The purpose of this privacy policy (this "Privacy Policy") is to inform users of our Site of the following:
                </p>
                <ol>
                    <li>The personal data we will collect;</li>
                    <li>Use of collected data;</li>
                    <li>Who has access to the data collected;</li>
                    <li>The rights of Site users; and</li>
                    <li>The Site's cookie policy.</li>
                </ol>
                <p>This Privacy Policy applies in addition to the terms and conditions of our Site.
                </p>
                <div>
                    <p><strong><u>GDPR</u></strong><br>For users in the European Union, we adhere to the Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016, known as the General Data Protection Regulation (the "GDPR"). For users in the United Kingdom, we adhere to the GDPR as enshrined in the Data Protection Act 2018.<br><br>We have not appointed a Data Protection Officer as we do not fall within the categories of controllers and processors required to appoint a Data Protection Officer under Article 37 of the GDPR.
                    </p>
                </div>
                <div>
                    <p><strong><u>Consent</u></strong><br>By using our Site users agree that they consent to:
                    </p>
                    <ol>
                        <li>The conditions set out in this Privacy Policy.</li>
                    </ol>
                    <p>When the legal basis for us processing your personal data is that you have provided your consent to that processing, you may withdraw your consent at any time. If you withdraw your consent, it will not make processing which we completed before you withdrew your consent unlawful.
                    </p>
                    <p>You can withdraw your consent by contacting: ourbookstop-privacy@simons.bulc.club, or delete your account via your user profile page.
                    </p>
                </div>
                <div>
                    <p><strong><u>Legal Basis for Processing</u></strong><br>We collect and process personal data about users in the EU only when we have a legal basis for doing so under Article 6 of the GDPR. <br><br>We rely on the following legal basis to collect and process the personal data of users in the EU:
                    </p>
                    <ol>
                        <li>Users have provided their consent to the processing of their data for one or more specific purposes.</li>
                    </ol>
                </div>
                <p><strong><u>Personal Data We Collect</u></strong><br>We only collect data that helps us achieve the purpose set out in this Privacy Policy. We will not collect any additional data beyond the data listed below without notifying you first.<br><br>
                </p>
                <p><u>Data Collected in a Non-Automatic Way</u><br>We may also collect the following data when you perform certain functions on our Site:
                </p>
                <ol>
                    <li>First and last name; and</li>
                    <li>Email address.</li>
                </ol>
                <p>This data may be collected using the following methods:
                </p>
                <ol>
                    <li>Authenticating via email address; and</li>
                    <li>Authenticating using Google Oauth.</li>
                </ol>
                <p><strong><u>How We Use Personal Data</u></strong><br>Data collected on our Site will only be used for the purposes specified in this Privacy Policy or indicated on the relevant pages of our Site. We will not use your data beyond what we disclose in this Privacy Policy.
                </p>
                <p>The data we collect when the user performs certain functions may be used for the following purposes:
                </p>
                <ol>
                    <li>Authentication - maintaining a user session; and</li>
                    <li>Communication - providing notifications for user driven actions.</li>
                </ol>
                <p><strong><u>Who We Share Personal Data With</u></strong><br><u>Employees</u><br>We may disclose user data to any member of our organisation who reasonably needs access to user data to achieve the purposes set out in this Privacy Policy.
                </p>
                <div>
                    <p><u>Other Disclosures</u><br>We will not sell or share your data with other third parties, except in the following cases:
                    </p>
                    <ol>
                        <li>If the law requires it;</li>
                        <li>If it is required for any legal proceeding;</li>
                        <li>To prove or protect our legal rights; and</li>
                        <li>To buyers or potential buyers of this company in the event that we seek to sell the company.</li>
                    </ol>
                    <p>If you follow hyperlinks from our Site to another Site, please note that we are not responsible for and have no control over their privacy policies and practices.
                    </p>
                </div>
                <p><strong><u>How Long We Store Personal Data</u></strong><br>User data will be stored until the purpose the data was collected for has been achieved.<br><br>You will be notified if your data is kept for longer than this period.
                </p>
                <p><strong><u>How We Protect Your Personal Data</u></strong><br>In order to protect your security, we use the strongest available browser encryption and store all of our data on servers in secure facilities. All data is only accessible to our employees. Our employees are bound by strict confidentiality agreements and a breach of this agreement would result in the employee's termination.<br><br>While we take all reasonable precautions to ensure that user data is secure and that users are protected, there always remains the risk of harm. The Internet as a whole can be insecure at times and therefore we are unable to guarantee the security of user data beyond what is reasonably practical.
                </p>
                <p><strong><u>Your Rights as a User</u></strong><br>Under the GDPR, you have the following rights:
                </p>
                <ol>
                    <li>Right to be informed;</li>
                    <li>Right of access;</li>
                    <li>Right to rectification;</li>
                    <li>Right to erasure;</li>
                    <li>Right to restrict processing;</li>
                    <li>Right to data portability; and</li>
                    <li>Right to object.</li>
                </ol>
                <div>
                    <p><strong><u>Children</u></strong><br>The minimum age to use our website is 16 years of age. We do not knowingly collect or use personal data from children under 16 years of age. If we learn that we have collected personal data from a child under 16 years of age, the personal data will be deleted as soon as possible. If a child under 16 years of age has provided us with personal data their parent or guardian may contact our privacy officer.
                    </p>
                </div>
                <p><strong><u>How to Access, Modify, Delete, or Challenge the Data Collected</u></strong><br>If you would like to know if we have collected your personal data, how we have used your personal data, if we have disclosed your personal data and to who we disclosed your personal data, if you would like your data to be deleted or modified in any way, or if you would like to exercise any of your other rights under the GDPR, please contact our privacy officer here:<br><br>Simon Wheelwright<br>ourbookstop-privacy@simons.bulc.club
                </p>
                <div>
                    <p><strong><u>How to Opt-Out of Data Collection, Use or Disclosure</u></strong><br>In addition to the method(s) described in the <em>How to Access, Modify, Delete, or Challenge the Data Collected</em> section, we provide the following specific opt-out methods for the forms of collection, use, or disclosure of your personal data specified below:
                    </p>
                    <ol>
                        <li>You can opt-out of the use of your personal data for non-essential notification emails (such as notifications of other users adding books to a shelf they share with you). You can opt-out by clicking "unsubscribe" on a notification email, or updating your email preferences in your profile or on the shelf.</li>
                    </ol>
                </div>
                <div>
                    <p><strong><u>Cookie Policy</u></strong><br>A cookie is a small file, stored on a user's hard drive by a website. Its purpose is to collect data relating to the user's browsing habits. You can choose to be notified each time a cookie is transmitted. You can also choose to disable cookies entirely in your internet browser, but this may decrease the quality of your user experience.
                    </p>
                    <p>We use the following types of cookies on our Site:
                    </p>
                    <ol>
                        <li><u><span>Functional cookies</span></u><br>Functional cookies are used to remember the selections you make on our Site so that your selections are saved for your next visits.<br>
                        </li>
                    </ol>
                </div>
                <p><strong><u>Modifications</u></strong><br>This Privacy Policy may be amended from time to time in order to maintain compliance with the law and to reflect any changes to our data collection process. When we amend this Privacy Policy we will update the "Effective Date" at the top of this Privacy Policy. We recommend that our users periodically review our Privacy Policy to ensure that they are notified of any updates. If necessary, we may notify users by email of changes to this Privacy Policy.
                </p>
                <p><strong><u>Complaints</u></strong><br>If you have any complaints about how we process your personal data, please contact us through the contact methods listed in the <em>Contact Information</em> section so that we can, where possible, resolve the issue. If you feel we have not addressed your concern in a satisfactory manner you may contact a supervisory authority. You also have the right to directly make a complaint to a supervisory authority. You can lodge a complaint with a supervisory authority by contacting the Information Commissioner's Office.
                </p>
                <p><strong><u>Contact Information</u></strong><br>If you have any questions, concerns or complaints, you can contact our privacy officer, Simon Wheelwright, at:<br><br>ourbookstop-privacy@simons.bulc.club
                </p>
            </div>
        </x-app-card>
    @endauth
</x-layouts.app>
