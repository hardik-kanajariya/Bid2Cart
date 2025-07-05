import React from 'react'

function AuctionDetailsGallaryTab(props) {
    let idCounter = 0;
    let active = true;
    return (<div
            className="col-xl-6 col-lg-7 d-flex flex-row align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">
            <ul className="nav small-image-list d-flex flex-md-column flex-row justify-content-center gap-4  wow fadeInDown"
                data-wow-duration="1.5s" data-wow-delay=".4s">
                {props.images.map((data) => {
                    idCounter = 1 + idCounter;
                    // console.log('counter = ' + idCounter)
                    return <li key={data} className="nav-item">
                        <div id="details-img1" data-bs-toggle="pill" data-bs-target={`#gallery-img${idCounter}`}
                             aria-controls={`gallery-img${idCounter}`}>
                            <img alt="image" src={data} className="img-fluid auction-side-image"/>
                        </div>
                    </li>
                })}
            </ul>
            <div className="tab-content mb-4 d-flex justify-content-lg-start justify-content-center  wow fadeInUp"
                 data-wow-duration="1.5s" data-wow-delay=".4s">
                <span className='d-none'> {idCounter = 0} {active = true}</span>
                {props.images.map((data) => {
                    idCounter = 1 + idCounter;
                    if (idCounter > 1) {
                        active = false;
                    }
                    return <div key={data} className={`tab-pane big-image fade show ${active ? 'active' : ''}`}
                                id={`gallery-img${idCounter}`}>
                        <img alt="image" src={data} className="img-fluid auction-main-image"/>
                    </div>
                })}
            </div>
        </div>)
}

export default AuctionDetailsGallaryTab