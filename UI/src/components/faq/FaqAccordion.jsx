import React from "react";
import ReactStars from "react-stars";
import Zoom from 'react-reveal/Zoom';

function FaqAccordion() {
    return (<div className="col-lg-8 col-md-12 text-center order-lg-2 order-1">
            <h2 className="section-title4">General FAQ’s</h2>
            <div
                className="faq-wrap wow fadeInUp"
                data-wow-duration="1.5s"
                data-wow-delay=".2s"
            >
                {/* Accordion Question starts from here */}
                <div className="accordion" id="accordionExample">
                    <Zoom cascade>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingOne">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne"
                                    aria-expanded="true"
                                    aria-controls="collapseOne"
                                >
                                    CAN YOU EXPLAIN YOUR RATING SCALE?
                                </button>
                            </h2>
                            <div
                                id="collapseOne"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        We rate every item up for auction from 1-6 stars located at
                                        the top right of the item page. This will indicate the
                                        condition of the item.
                                        <ReactStars edit={false} size={35} count={6} value={6}/>
                                        <b style={{"fontSize": "14px"}}>6 STARS - BRAND NEW RETAIL PACKAGING</b>
                                        <p className="para">
                                            (Exactly how it will look like if you bought the item in a
                                            retail store)
                                        </p>
                                        <ReactStars edit={false} size={35} count={6} value={5}/>
                                        <b style={{"fontSize": "14px"}}>
                                            5 STARS - NEW - Open/inspected box. Distressed OR missing
                                            packaging
                                        </b>
                                        <p className="para">
                                            (This mainly applies to electronics where there is a sticker
                                            seal)
                                        </p>
                                        <p className="para">
                                            A) Item Contents are BRAND NEW and shows no signs of use.
                                            Box/Package has been previously opened by a customer or
                                            opened and inspected by our staff (We inspect or test
                                            anything we feel is necessary to insure there is no damage,
                                            all parts are included and that the item works. We will
                                            state whether we inspected or tested it personally)
                                        </p>
                                        <p className="para">
                                            {" "}
                                            B) Item is NEW but retail packaging is distressed due to
                                            shipping, or item is missing its packaging/tags. (see photos
                                            of package){" "}
                                        </p>
                                        <ReactStars edit={false} size={35} count={6} value={4}/>
                                        <b style={{"fontSize": "14px"}}>
                                            4 STARS - NEW WITH MINOR ISSUE OR STORE RETURN OR STORE
                                            DISPLAY
                                        </b>
                                        <p className="para">
                                            Please see condition notes for further information.
                                        </p>
                                        <p className="para">Item has been inspected and or tested.</p>
                                        <ReactStars edit={false} size={35} count={6} value={3}/>
                                        <b style={{"fontSize": "14px"}}>3 STARS - MANUFACTURER REFURBISHED</b>
                                        <p className="para">
                                            Please see condition notes for further information.
                                        </p>
                                        <ReactStars edit={false} size={35} count={6} value={2}/>
                                        <b style={{"fontSize": "14px"}}>
                                            2 STARS - USED - Condition will vary. See condition notes
                                        </b>
                                        <p className="para">
                                            We will include additional photos and condition notes.
                                        </p>
                                        <ReactStars edit={false} size={35} count={6} value={1}/>
                                        <b style={{"fontSize": "14px"}}>1 STAR - AS-IS</b>
                                        <p className="para">
                                            A) Item has been tested and is defective. It is not in
                                            working condition or we are unable to get it to work
                                        </p>
                                        <p className="para">
                                            B) Item is being sold AS-IS because we are unable to test
                                            the item fully
                                        </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {/* <h2>HOW DO I BID?</h2> */}
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingTwo">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                >
                                    DO YOU HAVE RESERVES ON YOUR ITEMS?
                                </button>
                            </h2>
                            <div
                                id="collapseTwo"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        Some items may have reserves! All our auctions start at with
                                        an opening bid when listed and sell for the highest bid amount
                                        on auction night.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingThree">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree"
                                    aria-expanded="false"
                                    aria-controls="collapseThree"
                                >
                                    CAN I COME PREVIEW AN ITEM BEFORE BIDDING?
                                </button>
                            </h2>
                            <div
                                id="collapseThree"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        We encourage all our bidders if they have time to spare, to
                                        come to our retail location within our business hours and
                                        preview anything you are interested in bidding on.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingFour">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour"
                                    aria-expanded="false"
                                    aria-controls="collapseFour"
                                >
                                    WHAT DOES PROXY BIDDING MEAN?
                                </button>
                            </h2>
                            <div
                                id="collapseFour"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <ol>
                                        <li>
                                            Proxy Bid means: The max amount your willing to pay/bid for
                                            the item (this can be updated and increased at anytime)
                                        </li>
                                        <li>
                                            You will now decide to input a MAX PROXY BID. Ex: $40, the
                                            system will automatically keep you $1 higher than the
                                            previous bidder as long as your max bid is higher than
                                            theirs.
                                        </li>
                                        <li>
                                            Your proxy bid is kept SECRET from everyone, only you can
                                            see this amount.
                                        </li>
                                        <li>
                                            The main advantage to proxy bidding is if you are unable to
                                            watch the auction because you need to be away from the
                                            computer or phone, you can still win the item.
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingFive">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive"
                                    aria-expanded="false"
                                    aria-controls="collapseFive"
                                >
                                    CAN YOU GIVE ME AN EXAMPLE OF THE BIDDING PROCESS?
                                </button>
                            </h2>
                            <div
                                id="collapseFive"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p className="para">
                                        In this example 2 people will be bidding on a Watch <br/>
                                        &quot;Jacob86&quot; has placed his secret proxy bid and is
                                        currently winning the watch at $10. You decide that you would
                                        love to have this watch and bid $15
                                        <br/>
                                        Now 2 things will happen...
                                        <br/>
                                        Option A: You will now currently be winning that item for $11
                                        because you have outbid &quot;Jacob86&quot; max bid.
                                        <br/>
                                        Option B: The current bid jumps to $16, that means that
                                        &quot;Jacob86&quot; bid is still higher than your $15 and you
                                        must bid higher until you take the bidding lead and pass
                                        &quot;Jacob86&quot; secret bid.
                                        <br/>
                                        Now you decide to increase your bid to $25. The bid amount has
                                        just updated to $21 and you are now winning the watch. This
                                        means you have outbid &quot;Jacob86&quot; and surpassed his
                                        proxy bid amount which was obviously $20.
                                        <br/>
                                        You will know this because your bid will always be $1 higher
                                        than the previous bidder once you have outbid their proxy bid.
                                        This process will continue until the auction time ends on that
                                        item and someone has won the watch. <br/>
                                        What if &quot;Jacob86&quot; wants to bid the same amount as
                                        me? Whoever placed the max bid of $20 first will be winning
                                        the item for $20 as our system does not allow duplicate bid
                                        amounts.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingSix">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix"
                                    aria-expanded="false"
                                    aria-controls="collapseSix"
                                >
                                    HOW DO I KNOW IF I AM WINNING AN ITEM?
                                </button>
                            </h2>
                            <div
                                id="collapseSix"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>You can check your winning status in your Dashboard area</p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="headingSeven">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven"
                                    aria-expanded="false"
                                    aria-controls="collapseSeven"
                                >
                                    WHAT ELSE DO I NEED TO KNOW?
                                </button>
                            </h2>
                            <div
                                id="collapseSeven"
                                className="accordion-collapse collapse"
                                aria-labelledby="headingSeven"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        In the event of a Tie bid (2 bidders enter the same amount, it
                                        is always awarded to the first person who placed the bid.) If
                                        you enter a bid of $10 and the current high bid changes to $10
                                        but your thumbnail is red, that means someone else entered a
                                        $10 bid before you and will be recognized as the high bidder.
                                    </p>
                                </div>
                            </div>
                        </div>
                        {/* <h2>HOW DO I PAY?</h2> */}
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="eight">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#eight"
                                    aria-expanded="false"
                                    aria-controls="eight"
                                >
                                    WHEN IS PAYMENT DUE?
                                </button>
                            </h2>
                            <div
                                id="eight"
                                className="accordion-collapse collapse"
                                aria-labelledby="eight"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        Payment is due by the deadline indicated in our banner or
                                        emails for that auction. 4 days after the auction ends. The
                                        Sunday of that week by 4pm THERE ARE NO EXCEPTIONS You cannot
                                        pick and choose which items to pay for when you come for your
                                        won auction items. You must pay for your ENTIRE order
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="nine">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#nine"
                                    aria-expanded="false"
                                    aria-controls="nine"
                                >
                                    WHAT IF I DO NOT PAY FOR MY ORDER AND PICK UP ON TIME?
                                </button>
                            </h2>
                            <div
                                id="nine"
                                className="accordion-collapse collapse"
                                aria-labelledby="nine"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        If an invoice is left unpaid and not picked up by the deadline
                                        the account will automatically be temporarily suspended and
                                        the items re-listed. The bidder will then be required to pay
                                        the 15% restocking fee off the final invoice amount that was
                                        left unpaid in order to re-instate their account. Once the
                                        account has been suspended the bidder will no longer be
                                        allowed to bid, purchase, or pick-up any items until this
                                        restocking fee is paid.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="ten">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#ten"
                                    aria-expanded="false"
                                    aria-controls="ten"
                                >
                                    HOW DO I PAY (METHODS OF PAYMENT)?
                                </button>
                            </h2>
                            <div
                                id="ten"
                                className="accordion-collapse collapse"
                                aria-labelledby="ten"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        1. This can be done in person at our retail location. We
                                        accept Cash, Debit and Credit (Mastercard, Visa and American
                                        Express). E-transfers are also accepted but they need to be
                                        cleared before any items can leave the location. 2. We no
                                        longer accept online or over the phone payments. Please
                                        contact us via site message or phone to inform us if you need
                                        to do an E-transfer
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="eleven">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#eleven"
                                    aria-expanded="false"
                                    aria-controls="eleven"
                                >
                                    IS THERE ANY OTHER CHARGES WHEN I PAY FOR MY ITEMS?
                                </button>
                            </h2>
                            <div
                                id="eleven"
                                className="accordion-collapse collapse"
                                aria-labelledby="eleven"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        ABSOLUTELY NOT! Bidding is completely FREE! No scams or buying
                                        bids, what you win your item for is what you pay + the
                                        standard 10% buyers premium + HST. All items up for auction
                                        are subject to the 10% buyers premium being added to the
                                        winning bid amount which constitutes the final purchase price.
                                        Example: $40 winning bid. + 10% premium = $4 ($44 final
                                        purchase price + 13% HST) = $49.72
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="twelve">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#twelve"
                                    aria-expanded="false"
                                    aria-controls="twelve"
                                >
                                    WHAT IF I WOULD LIKE TO REFUSE AN ITEM BECAUSE I CHANGED MY
                                    MIND?
                                </button>
                            </h2>
                            <div
                                id="twelve"
                                className="accordion-collapse collapse"
                                aria-labelledby="twelve"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        Most auctions do not accommodate this request but we allow
                                        refusal of a won item if a restocking fee is paid off the
                                        total bid amount which is the winning bid amount (+ the 10%
                                        buyers premium). This will give you the total bid amount. 15%
                                        of that amount is our restocking fee.
                                        <br/>
                                        Example:
                                        <br/>
                                        Won item for $50
                                        <br/>
                                        10% Buyers Premium is $5
                                        <br/>
                                        Total Bid amount will be $55
                                        <br/>
                                        15% of $55 would be your restocking fee for that one item
                                        $8.25
                                    </p>
                                </div>
                            </div>
                        </div>
                        {/* <h2>HOW DO I PICK-UP MY ITEMS?</h2> */}
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="thirteen">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#thirteen"
                                    aria-expanded="false"
                                    aria-controls="thirteen"
                                >
                                    WHAT IF I CAN&apos;T MAKE IT WITHIN THE PICK-UP TIMEFRAME?
                                </button>
                            </h2>
                            <div
                                id="thirteen"
                                className="accordion-collapse collapse"
                                aria-labelledby="thirteen"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        There are no exceptions to the 4 days pick-up after auction
                                        unless an emergency has occurred and a time extension is
                                        granted by one of our staff.
                                        <br/>
                                        IF YOU CAN&apos;T PICK UP WITHIN OUR 4 DAY TIME FRAME DO NOT
                                        BID!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="fourteen">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#fourteen"
                                    aria-expanded="false"
                                    aria-controls="fourteen"
                                >
                                    DO I HAVE TO SCHEDULE A PICK-UP BEFORE I COME?
                                </button>
                            </h2>
                            <div
                                id="fourteen"
                                className="accordion-collapse collapse"
                                aria-labelledby="fourteen"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        While scheduling a pick-up is not mandatory, we highly
                                        recommend it as this allows us to try and prepare your order
                                        ahead of time. This would minimize your wait time when you
                                        come to our store to pick-up. If you are interested in
                                        scheduling a pick-up time, it can be done by phoning us for
                                        fastest response or an internal site message.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="fifteen">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#fifteen"
                                    aria-expanded="false"
                                    aria-controls="fifteen"
                                >
                                    WHAT DO I NEED WHEN I COME PICK-UP?
                                </button>
                            </h2>
                            <div
                                id="fifteen"
                                className="accordion-collapse collapse"
                                aria-labelledby="fifteen"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        All new members are required to show Government-issued ID when
                                        picking up an order. This is done to protect us and the
                                        bidders by ensuring the items are picked up by their rightful
                                        winner. There are NO exceptions!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="sixteen">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#sixteen"
                                    aria-expanded="false"
                                    aria-controls="sixteen"
                                >
                                    CAN SOMEONE ELSE PICK-UP MY ORDER?
                                </button>
                            </h2>
                            <div
                                id="sixteen"
                                className="accordion-collapse collapse"
                                aria-labelledby="sixteen"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        If you would like someone else to pick up your order, please
                                        log into your account and use the internal messaging system
                                        and provide the full name of the person who will be picking
                                        your order. This person will be required to present a
                                        government-issued ID on arrival.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h2>WHAT IS YOUR WARRANTY/RETURN POLICY?</h2>
                        <div className="accordion-item">
                            <h2 className="accordion-header" id="seventeen">
                                <button
                                    className="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#seventeen"
                                    aria-expanded="false"
                                    aria-controls="seventeen"
                                >
                                    WHAT IS YOUR WARRANTY/RETURN POLICY?
                                </button>
                            </h2>
                            <div
                                id="seventeen"
                                className="accordion-collapse collapse"
                                aria-labelledby="seventeen"
                                data-bs-parent="#accordionExample"
                            >
                                <div className="accordion-body">
                                    <p>
                                        WE DO NOT DO BUYER REMORSE RETURNS, WE OFFER A 14 DAY WARRANTY
                                        ON ANY ITEMS THAT DO NOT LIVE UP TO OUR LISTING (FULL MONEY
                                        BACK) We stand by the items we sell and because of that we
                                        supply an in-house warranty on everything sold, unless stated
                                        AS-IS. Warranty applies for... Any items that have a
                                        malfunction from time of purchase, was damaged and not
                                        described, missing parts and not indicated or was listed
                                        incorrectly. To be granted a return we must be contacted
                                        within 14 days explaining the issue. This can be done by
                                        contacting us via internal message (top right of the screen
                                        *green button*) Once a return has been approved, the item will
                                        be replaced if a duplicate is available, we will offer a
                                        negotiated discount if the bidder would like to still keep the
                                        item or process a full refund. A bidder can&apos;t deny a
                                        replacement if one is available. Any physical damage caused by
                                        improper handling or use by the customer will result in
                                        automatic refusal for a refund and will void our 14 day
                                        warranty. Any malfunctions caused by improper use by the
                                        customer will also be denied. We will also deny a return if
                                        the bidder did not properly take the time to view and read the
                                        listing correctly. It is the bidders sole responsibility to
                                        fully read each listing and look at all photos as we put a lot
                                        of time into trying to be as accurate in our inspection and
                                        listing process. If a listing indicated an issue in the
                                        condition notes or included photos of the issue the return
                                        will be refused. We do NOT accept returns based on buyers
                                        remorse (You do not like the item, wasn&apos;t what you
                                        needed, clothing/shoes didn&apos;t fit or changed your mind)
                                        Once the warranty time period has exceeded no refunds or
                                        exchanges will be granted regardless of the issue or
                                        situation. There are NO exceptions. Once the warranty period
                                        has fully passed, we no longer hold anymore responsibility for
                                        the items sold. Please remember we are only human and deal
                                        with a large volume of products that need to be listed within
                                        a limited time frame. We appreciate your understanding if we
                                        miss an issue during the listing/inspecting process. If this
                                        does occur, we will resolve it for you!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </Zoom>
                </div>
            </div>
        </div>);
}

export default FaqAccordion;
