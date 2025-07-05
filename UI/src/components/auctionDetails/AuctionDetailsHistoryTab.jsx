import React, {useEffect, useState} from 'react'
import ReactStars from 'react-stars'
import {toast, ToastContainer} from 'react-toastify';
import Router from 'next/router';

function AuctionDetailsHistoryTab(props) {
    const [username, setUserName] = useState('')
    const [productId, setProductId] = useState('')
    const [question, setQuestion] = useState('')
    const [desc, setDesc] = useState('')

    useEffect(() => {
        setUserName(sessionStorage.getItem('username'))
        setProductId(props.pid)
        setDesc(props.desc)
    }, [props])
    const requestSupport = async (e) => {
        e.preventDefault();
        if (!sessionStorage.getItem('token')) {
            await Router.push('/login')
        }
        let headersList = {
            "Accept": "*/*",
            "Authorization": "Bearer " + sessionStorage.getItem('token'),
            "Content-Type": "application/json"
        }

        let bodyContent = JSON.stringify({
            "pid": productId, "question": question
        });
        //  `${process.env.NEXT_PUBLIC_API_URL}/api/request-support`
        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/request-support`, {
            method: "POST", body: bodyContent, headers: headersList
        });

        let data = await response.json();
        //  console.log(data);
        if (data.status === true) {
            toast.success(data.msg)
        } else {
            toast.warning(data.msg)
        }

    }

    return (<div className="col-lg-8">
            <ToastContainer/>
            <ul className="nav nav-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown"
                data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                <li className="nav-item" role="presentation">
                    <button className="nav-link active details-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Description
                    </button>
                </li>
                <li className="nav-item" role="presentation">
                    <button className="nav-link details-tab-btn" id="pills-bid-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-bid" type="button" role="tab" aria-controls="pills-bid"
                            aria-selected="false">Bidding History
                    </button>
                </li>
                <li className="nav-item" role="presentation">
                    <button className="nav-link details-tab-btn" id="pills-support-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-support" type="button" role="tab" aria-controls="pills-support"
                            aria-selected="false">Support
                    </button>
                </li>
            </ul>
            {/* Bidding Description Section */}
            <div className="tab-content" id="pills-tabContent">
                <div className="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                     id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div
                        className='container shadow-sm text-center d-flex justify-content-center flex-column align-items-center'>
                        <ReactStars edit={false} size={35} count={6} value={6}/>
                        <p>BRAND NEW RETAIL PACKAGING</p>
                        <ReactStars edit={false} size={35} count={6} value={5}/>
                        <p>NEW COMPLETE - Open/inspected box. Distressed OR missing packaging</p>
                        <ReactStars edit={false} size={35} count={6} value={4}/>
                        <p>NEW WITH MINOR ISSUE OR STORE RETURN OR STORE DISPLAY</p>
                        <ReactStars edit={false} size={35} count={6} value={3}/>
                        <p>MANUFACTURER REFURBISHED</p>
                        <ReactStars edit={false} size={35} count={6} value={2}/>
                        <p>USED - Conditions will vary. See condition notes.</p>
                        <ReactStars edit={false} size={35} count={6} value={1}/>
                        <p>AS-IS - Conditions will vary. See condition notes.</p>
                        <div className="describe-content"><b>Condition Note: </b><span
                            dangerouslySetInnerHTML={{__html: desc}}></span></div>
                        <div className='m-1'><b>Buyers Premium: </b>10%</div>
                        <div className='m-1'><b>SKU-Code: </b>{props.sku}</div>
                        <div className='m-1 pb-3'><b>Auction Ends: </b>{props.endtime}</div>

                    </div>
                </div>
                {/* Bidding Description Section Ends Here */}
                {/* Bidding History Tables Starts from here */}
                <div className="tab-pane fade" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                    <div className="bid-list-area">
                        <ul className="bid-list">
                            {/* Single Item Start here */}
                            {props.history ? props.history.map((item) => {
                                return <li key={item.id}>
                                    <div className="row d-flex align-items-center">
                                        <div className="col-7">
                                            <div className="bidder-area">
                                                <div className="bidder-img">
                                                    <img alt="image" width={50} height={50}
                                                         src="data:image/jpeg;base64,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"/>
                                                </div>
                                                <div className="bidder-content">
                                                    <a><h6>{item.bidder}</h6></a>
                                                    <p>{item.amount}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-5 text-end">
                                            <div className="bid-time">
                                                <p>{item.created_at}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            }) : 'No Bids Placed on this product'}
                            {/* Single Item Ends Here */}
                        </ul>
                    </div>
                </div>
                {/* Bidding History table Ends Here */}
                {/* Support Tab */}
                <div className="tab-pane fade" id="pills-support" role="tabpanel" aria-labelledby="pills-support-tab">
                    <div className="bid-list-area">
                        <form className="w-100" onSubmit={requestSupport}>
                            <div className="row">
                                <div className="col-12">
                                    <div className="form-inner">
                                        <label>Your Username: </label>
                                        <input type="email" className='form-control' placeholder={username} readOnly/>
                                    </div>
                                </div>
                                <div className="col-12">
                                    <div className="form-inner">
                                        <label>Enter your Query</label>
                                        <input type="text" className='form-control' placeholder="Enter Your query"
                                               onChange={(event) => {
                                                   setQuestion(event.target.value)
                                               }} value={question} required={true}/>
                                    </div>
                                </div>
                            </div>
                            <button type='submit' className="mt-3 nav-link details-tab-btn border-1">Request Support
                            </button>
                        </form>
                    </div>
                </div>
                {/* Support tab Ends here */}
            </div>
        </div>)
}

export default AuctionDetailsHistoryTab