ALTER TABLE tblItems
ADD constraint itemid_pk PRIMARY KEY(ItemID);

ALTER TABLE tblBids
ADD constraint bidderid_pk PRIMARY KEY(BidderID);

ALTER TABLE tblUsers
ADD constraint seller_pk PRIMARY KEY(Seller);

ALTER TABLE tblBids
ADD constraint itemid_fk FOREIGN KEY(ItemID) REFERENCES Items(ItemID);

ALTER TABLE tblItems
ADD constraint bidder_overzero CHECK(First_bid >= 0 AND Number_of_bids >= 0);
ALTER TABLE tblBids
ADD constraint bid_overzero CHECK(BidAmount >= 0 AND BidderRating >= 0);
ALTER TABLE tblUsers
ADD constraint sellerrating_overzero CHECK(SellerRating >= 0);
