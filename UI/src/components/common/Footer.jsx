import Link from 'next/link'
import React from 'react'

function Footer() {
    return (<footer>
            <div className="justify-content-lg-end p-2">
                <ul className="footer-list d-flex flex-row justify-content-center align-items-center flex-sm-nowrap flex-wrap">
                    <li className='text-white'><Link href="/about">ABOUT US</Link></li>
                    &nbsp;&nbsp;&nbsp;
                    <li className='text-white'><Link href="/how-works">HOW TO BID?</Link></li>
                    &nbsp;&nbsp;&nbsp;
                    <li className='text-white'><Link href="/faq">HOW DO I PICK-UP?</Link></li>
                    &nbsp;&nbsp;&nbsp;
                    <li className='text-white'><Link href="/contact">CONTACT US</Link></li>
                    &nbsp;&nbsp;&nbsp;
                    <li className='text-white'><Link href="/policy">PRIVACY POLICY</Link></li>
                    &nbsp;&nbsp;&nbsp;
                    <li className='text-white'><Link href="/terms">TERMS & CONDITION</Link></li>
                    &nbsp;&nbsp;&nbsp;
                </ul>
            </div>
            <div className="footer-bottom">
                <div className="container">
                    <div className="row d-flex align-items-center g-4">
                        <div className="col-lg-6 d-flex justify-content-lg-start justify-content-center">
                            <p>Copyright 2022 <Link href="/">Bid2Cart</Link> | Design By <a
                                href="https://www.riseuptechnology.com/" className="egns-lab">Riseup Technology</a></p>
                        </div>
                        {/* Adding Version */}
                        <div className="col-lg-6 d-flex justify-content-lg-end justify-content-center">
                            <p>Version 1.0.2</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    )
}

export default Footer