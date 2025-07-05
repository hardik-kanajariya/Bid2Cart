import React, {useEffect, useState} from 'react'
import {useRouter} from 'next/router'
import Layout from "../../components/layout/Layout";
import Preloader from "../../components/common/Preloader";
import Link from 'next/link';

export default function MailHash() {
    const router = useRouter()
    const {mail_hash} = router.query
    const [isLoaded, setIsLoaded] = useState(true);
    const [isVerified, setIsVerified] = useState(false);
    useEffect(() => {
        // Verifying Email Address using Api Call
        const checkVerify = async () => {
            let headersList = {
                "Accept": "application/json"
            }
            //
            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/auth/verify?mail_hash=${mail_hash}`, {
                method: "GET",
                headers: headersList
            });

            let data = await response.json();
            // console.log(data.status);
            setIsLoaded(false)
            if (data.status === true) {
                setIsVerified(true)
            }
        }
        checkVerify();

    }, [mail_hash])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<>
                <Layout>
                    <style jsx>{`
                      h1 {
                        color: #88B04B;
                        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                        font-weight: 900;
                        font-size: 40px;
                        margin-bottom: 10px;
                      }

                      p {
                        color: #404F5E;
                        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                        font-size: 20px;
                        margin: 0;
                      }

                      i {
                        color: #9ABC66;
                        font-size: 100px;
                        line-height: 200px;
                        margin-left: -15px;
                      }

                      .card {
                        background: white;
                        padding: 60px;
                        border-radius: 4px;
                        box-shadow: 0 2px 3px #C8D0D8;
                        display: inline-block;
                        margin: 0 auto;
                      }

                      .checkBox {
                        border-radius: 200px;
                        height: 200px;
                        width: 200px;
                        background: #F8FAF5;
                        margin: 0 auto;
                      }
                    `}</style>
                    <div className="live-auction-section pt-3 pb-120">
                        <img
                            alt="image"
                            src="/assets/images/bg/section-bg.png"
                            className="img-fluid section-bg-top"
                        />
                        <img
                            alt="image"
                            src="/assets/images/bg/section-bg.png"
                            className="img-fluid section-bg-bottom"
                        />
                        <div className="row">
                            <div className="card">
                                {isVerified ? (
                                    <>
                                        <div>
                                            <i className="checkmark">✓</i>
                                        </div>
                                        <h1>Verified</h1>
                                        <p>Your Email is Now Verified please wait to get approved by administrator to
                                            start bidding</p>
                                    </>
                                ) : (
                                    <>
                                        <div>
                                            <i className="checkmark p-5">X</i>
                                        </div>
                                        <h1>Not Verified</h1>
                                        <p>
                                            We are sorry! your email is not Verified please try again after some time or
                                            contact administrator
                                        </p>
                                        <Link href="/contact" className='btn btn--primary'>
                                            <a className='btn btn--primary mt-2 border-0'>Contact Now</a>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </Layout> </>)}
        </>
    );
}
