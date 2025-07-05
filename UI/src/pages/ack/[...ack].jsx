import React, {useEffect, useState} from 'react'
import {useRouter} from 'next/router'
import Layout from "../../components/layout/Layout";
import Preloader from "../../components/common/Preloader";
import Link from 'next/link';

export default function MailHash() {
    const router = useRouter()
    const [isLoaded, setIsLoaded] = useState(true);
    const [invoiceNumber, setInvoiceNumber] = useState('');
    const [status, setStatus] = useState('');
    const [isVerified, setIsVerified] = useState(false);

    // Acknowledgement handling 

    useEffect(() => {
        const checkVerify = async (invoiceNumber, status) => {
            let headersList = {
                "Accept": "*/*",
            }

            let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/invoice/${invoiceNumber}/${status}`, {
                method: "GET",
                headers: headersList
            });

            let data = await response.json();
            // console.log(data);
            setIsLoaded(false)
            if (data.status === true) {
                setIsVerified(true)
            }
        }
        if (router.isReady) {
            const props = router.query
            if (!props.ack) {
                return null
            } else {
                setInvoiceNumber(props.ack[0])
                setStatus(props.ack[1])
                checkVerify(invoiceNumber, status).then(r => r);
            }
        }
        setIsLoaded(false)
    }, [router.isReady, router.query, invoiceNumber, status])
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
                                        <h1>Acknowledgement Received</h1>
                                        <h4>Great now you can pickup product from store</h4>
                                        <p>Address:
                                            <address>
                                                Box 564, Disneyland<br/>
                                                CANADA
                                            </address>
                                        </p>
                                    </>
                                ) : (
                                    <>
                                        <div>
                                            <i className="checkmark p-5">X</i>
                                        </div>
                                        <h1>Some Error Occurred</h1>
                                        <p>We are sorry! your we are facing some issues, please try again after some
                                            time or contact administrator</p>
                                        <Link href="/contact">
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
