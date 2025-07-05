import React, {useEffect, useState} from "react";
import Link from 'next/link';
import Counter from '../common/Counter';
import ReactStars from 'react-stars';
import Image from 'next/image';
import Preloader from "../common/Preloader";
import {toast, ToastContainer} from 'react-toastify';
import Router from "next/router";
import {console} from "next/dist/compiled/@edge-runtime/primitives/console";

export default function LiveAuction(props) {
    const [products, setProducts] = useState([])
    const [isLoaded, setIsLoaded] = useState(true)
    const [amount, setAmount] = useState([]);
    const [bidConfirm, setBidConfirm] = useState(false);

    useEffect(() => {
        const getAllProducts = async () => {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/products/latest`);
            const data = await res.json()
            setProducts(data.data)
        }

        getAllProducts().then(r => setIsLoaded(false));
        setIsLoaded(false)

    }, [props, bidConfirm, amount])

    // Function to add product to watch list
    async function addWatchList(id) {
        // if user is not logged in
        if (!sessionStorage.getItem('token')) {
            toast.error('Please login to add product to watch list');
            return;
        }
        // using Fetch API 
        let headersList = {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let bodyContent = JSON.stringify({
            "pid": id,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/add/watchlist`, {
            method: "POST",
            body: bodyContent,
            headers: headersList
        });

        let data = await response.json();
        // console.log(data);
        toast.success(data.message);
    }

    // Function to get confirmation from user 
    async function onConfirm() {
        // check if user is logged in
        if (!sessionStorage.getItem('token')) {
            await Router.push('/login');
            return;
        }
        console.log(amount);
        if (!confirm(`Are you sure you want to place bid of ${amount[0].amount}?`)) {
            return
        }
        // Placing Bid if user confirms
        await placeBid();
    }

    // Function to prevent user from entering negative values
    function preventNegative(e) {
        if (e.target.value < 0) {
            e.target.value = 0;
        }
    }

    // Function to place Bid 
    async function placeBid() {
        if (amount[0].amount === '') {
            toast.error("Oops! Something went wrong please try again :)")
            return
        }

        // Negative amount check
        if (amount[0].amount < 0) {
            toast.error("Please enter valid amount")
            return
        }

        let headersList = {
            'Content-Type': 'application/json',
            "Access-Control-Allow-Origin": "*",
            "Authorization": "Bearer " + sessionStorage.getItem('token')
        }

        let bodyContent = JSON.stringify({
            "pid": amount[0].id,
            "amount": amount[0].amount,
        });

        let response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/bid`, {
            method: "POST",
            body: bodyContent,
            headers: headersList
        });

        let data = await response.json();
        toast.success(data.msg)
        setAmount([]);
    }

    // Checking Products is empty or not 
    function isEmptyObject(obj) {
        return JSON.stringify(obj) === '[]';
    }

    // Custom image loader 
    const customImageLoader = ({src}) => {
        return src;
    }

    // Function to detect Expired Auction
    function isExpired(date) {
        let now = new Date();
        let end = new Date(date);
        return end < now;
    }

    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (
                <div className="live-auction pb-120">
                    <ToastContainer/>
                    <img alt="image" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg"/>
                    <div className="container position-relative">
                        <img alt="image" src="/assets/images/bg/dotted1.png" className="dotted1"/>
                        <img alt="image" src="/assets/images/bg/dotted1.png" className="dotted2"/>
                        <div className="row d-flex justify-content-center">
                            <div className="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div className="section-title">
                                    <h2>Live Auction</h2>
                                    <p className="mb-3">Explore on the world&apos;s best &amp; largest Bidding
                                        marketplace with our beautiful Bidding
                                        products. We want to be a part of your smile, success and future growth.</p>
                                </div>
                            </div>
                        </div>
                        <div className="row gy-4 mb-60 d-flex justify-content-center">
                            {products && products.map(props => {
                                return isExpired(props.end_time) ? '' : <div key={props.prd_id} className="col-lg-4 col-md-6 col-sm-12">
                                    <div data-wow-duration="1.5s" data-wow-delay="0.2s"
                                         className="eg-card auction-card wow animate fadeInDown">
                                        <Link href={`/auction/${props.prd_id}/${props.title}`}>
                                            <div className="auction-img">
                                                <Image loader={customImageLoader} alt="image" src={props.thumbnail}
                                                       width={500} height={500}/>
                                                <div className="auction-timer shadow-sm">
                                                    <div className="countdown" id="timer1">
                                                        <h4><Counter formate="counter3" date={props.end_time}/></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </Link>
                                        <div className="auction-content">
                                            <ReactStars value={props.condition_rating} size={20} count={6}
                                                        edit={false}/>
                                            <h4><Link
                                                href={`/auction/${props.prd_id}/${props.title}`}><a>{props.title}</a></Link>
                                            </h4>
                                            <p>Bidding Price : <span><span>${props.current_bid}</span></span></p>
                                            <div className="auction-card-bttm">
                                                <input id={props.prd_id} className='form-control' type="number" style={{
                                                    width: "100px",
                                                    padding: "5px"
                                                }} onChange={(e) => {
                                                    preventNegative(e);
                                                    setAmount([{"id": props.prd_id, "amount": Math.abs(e.target.value)}])
                                                }} value={amount.amount}/>
                                                <a className="eg-btn btn--primary btn--sm" onClick={onConfirm}>Place a
                                                    Bid</a>
                                                <div className="share-area">
                                                    <div>
                                                        <div className="share-btn" role='button'>
                                                            <i className='bx bx-sm bx-heart-circle'
                                                               onClick={() => addWatchList(props.prd_id)}/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            })}
                            {isEmptyObject(products) ? (<h2 className="text-center">No Products Found</h2>) : ''}
                        </div>
                        <div className="row d-flex justify-content-center">
                            <div className="col-md-4 text-center">
                                <Link href="/live-auction"><a className="eg-btn btn--primary btn--md mx-auto">View
                                    All</a></Link>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    )
}
