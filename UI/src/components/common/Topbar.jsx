import React from "react";

function Topbar() {
    return (
        <>
            <div className="topbar">
                <div className="topbar-left d-flex flex-row align-items-center">
                    <h6>Follow Us</h6>
                    <ul className="topbar-social-list gap-2">
                        <li><a href={process.env.NEXT_PUBLIC_SOCIAL_FACEBOOK}><i className="bx bxl-facebook"/></a></li>
                        <li><a href={process.env.NEXT_PUBLIC_SOCIAL_TWITTER}><i className="bx bxl-twitter"/></a></li>
                        <li><a href={process.env.NEXT_PUBLIC_SOCIAL_INSTAGRAM}><i className="bx bxl-instagram"/></a>
                        </li>
                        <li><a href={process.env.NEXT_PUBLIC_SOCIAL_PINTREST}><i className="bx bxl-pinterest-alt"/></a>
                        </li>
                    </ul>
                </div>
                <div className="email-area">
                    <h6>Email: <a href="mailto:contact@example.com">{process.env.NEXT_PUBLIC_CONTACT_EMAIL}</a></h6>
                </div>
            </div>
        </>
    );
}

export default Topbar;