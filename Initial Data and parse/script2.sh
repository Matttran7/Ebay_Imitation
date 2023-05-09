
ALTER TABLE Items
ADD CONSTRAINT itemid_pk PRIMARY KEY(ItemID);
ALTER TABLE Bidder
ADD CONSTRAINT bidderid_pk PRIMARY KEY(BidderID);
ALTER TABLE Seller
ADD CONSTRAINT Seller_pk PRIMARY KEY(Seller);

ALTER TABLE Bidder
ADD CONSTRAINT bidderid_fk FOREIGN KEY(ItemID) REFERENCES Items(ItemID);

ALTER TABLE Items
ADD CONSTRAINT Item_Over_zero_ck CHECK(First_bid >= 0 AND Number_of_bids >= 0);
ALTER TABLE Bidder
ADD CONSTRAINT bidder_over_zero CHECK(BidAmount >= 0 AND BidderRating >= 0);
ALTER TABLE Seller
ADD CONSTRAINT seller_over_zero CHECK(SellerRating >= 0);
