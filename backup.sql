--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2 (Debian 17.2-1.pgdg120+1)
-- Dumped by pg_dump version 17.2 (Debian 17.2-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: is_time_available(integer, date); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.is_time_available(p_petsitter_id integer, p_date date) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN NOT EXISTS (
        SELECT 1 FROM visit
        WHERE petsitter_id = p_petsitter_id
        AND DATE(start_date) = p_date
        AND confirmed = true
    );
END;
$$;


ALTER FUNCTION public.is_time_available(p_petsitter_id integer, p_date date) OWNER TO docker;

--
-- Name: update_visit_status(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.update_visit_status() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.canceled = true THEN
        NEW.confirmed = false;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_visit_status() OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: pet; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.pet (
    user_id integer,
    name character varying(100) NOT NULL,
    age integer,
    breed character varying(100),
    additional_info text,
    photo_url character varying(255),
    id integer NOT NULL,
    pet_type character varying(10),
    CONSTRAINT check_pet_type CHECK (((pet_type)::text = ANY ((ARRAY['dog'::character varying, 'cat'::character varying, 'rodent'::character varying])::text[])))
);


ALTER TABLE public.pet OWNER TO docker;

--
-- Name: pet_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.pet_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pet_id_seq OWNER TO docker;

--
-- Name: pet_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.pet_id_seq OWNED BY public.pet.id;


--
-- Name: petsitter; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.petsitter (
    user_id integer NOT NULL,
    id integer NOT NULL,
    description text,
    is_dog_sitter boolean DEFAULT false,
    is_cat_sitter boolean DEFAULT false,
    is_rodent_sitter boolean DEFAULT false,
    hourly_rate numeric(10,2),
    care_at_owner_home boolean DEFAULT false,
    care_at_petsitter_home boolean DEFAULT false,
    dog_walking boolean DEFAULT false
);


ALTER TABLE public.petsitter OWNER TO docker;

--
-- Name: petsitter_availability; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.petsitter_availability (
    id integer NOT NULL,
    petsitter_id integer,
    date date,
    is_available boolean DEFAULT true
);


ALTER TABLE public.petsitter_availability OWNER TO docker;

--
-- Name: petsitter_availability_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.petsitter_availability_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.petsitter_availability_id_seq OWNER TO docker;

--
-- Name: petsitter_availability_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.petsitter_availability_id_seq OWNED BY public.petsitter_availability.id;


--
-- Name: petsitter_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.petsitter_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.petsitter_id_seq OWNER TO docker;

--
-- Name: petsitter_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.petsitter_id_seq OWNED BY public.petsitter.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."user" (
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    id integer NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    phone character varying(20),
    city character varying(100),
    street character varying(100),
    house_number character varying(20),
    apartment_number character varying(20),
    postal_code character varying(10)
);


ALTER TABLE public."user" OWNER TO docker;

--
-- Name: visit; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.visit (
    id integer NOT NULL,
    user_id integer NOT NULL,
    petsitter_id integer NOT NULL,
    care_type character varying(50) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    confirmed boolean DEFAULT false,
    canceled boolean DEFAULT false,
    pets integer[]
);


ALTER TABLE public.visit OWNER TO docker;

--
-- Name: petsitter_statistics; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.petsitter_statistics AS
 SELECT p.id AS petsitter_id,
    u.first_name,
    u.last_name,
    count(v.id) AS total_visits,
    count(
        CASE
            WHEN (v.confirmed = true) THEN 1
            ELSE NULL::integer
        END) AS confirmed_visits,
    count(
        CASE
            WHEN (v.canceled = true) THEN 1
            ELSE NULL::integer
        END) AS canceled_visits,
    count(
        CASE
            WHEN ((v.confirmed = true) AND (v.end_date < CURRENT_DATE)) THEN 1
            ELSE NULL::integer
        END) AS completed_visits
   FROM ((public.petsitter p
     JOIN public."user" u ON ((p.user_id = u.id)))
     LEFT JOIN public.visit v ON ((p.id = v.petsitter_id)))
  GROUP BY p.id, u.first_name, u.last_name;


ALTER VIEW public.petsitter_statistics OWNER TO docker;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_id_seq OWNER TO docker;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: visit_details; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.visit_details AS
 SELECT v.id AS visit_id,
    u.first_name AS owner_name,
    u.last_name AS owner_lastname,
    ps.id AS petsitter_id,
    v.start_date,
    v.end_date,
    v.care_type,
    v.confirmed,
    v.canceled
   FROM ((public.visit v
     JOIN public."user" u ON ((v.user_id = u.id)))
     JOIN public.petsitter ps ON ((v.petsitter_id = ps.id)));


ALTER VIEW public.visit_details OWNER TO docker;

--
-- Name: visit_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.visit_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.visit_id_seq OWNER TO docker;

--
-- Name: visit_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.visit_id_seq OWNED BY public.visit.id;


--
-- Name: pet id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.pet ALTER COLUMN id SET DEFAULT nextval('public.pet_id_seq'::regclass);


--
-- Name: petsitter id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter ALTER COLUMN id SET DEFAULT nextval('public.petsitter_id_seq'::regclass);


--
-- Name: petsitter_availability id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter_availability ALTER COLUMN id SET DEFAULT nextval('public.petsitter_availability_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Name: visit id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.visit ALTER COLUMN id SET DEFAULT nextval('public.visit_id_seq'::regclass);


--
-- Data for Name: pet; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.pet (user_id, name, age, breed, additional_info, photo_url, id, pet_type) FROM stdin;
7	Karmel	3	kundelek	nadpobudliwy	../Public/img/default-pet.svg	9	dog
9	Max	4	Golden Retriever		\N	10	dog
9	Luna	1	Beagle		\N	11	dog
8	Lily	3	Devon rex		\N	12	cat
6	Tara	12	brytyjski		../Public/img/default-pet.svg	3	dog
1	Milky	2	Akita		\N	13	dog
1	Kenzo	5	Shiba inu		\N	14	dog
6	Dyzia	5	British 		\N	15	cat
1	Karo	4	Akita		\N	16	dog
\.


--
-- Data for Name: petsitter; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.petsitter (user_id, id, description, is_dog_sitter, is_cat_sitter, is_rodent_sitter, hourly_rate, care_at_owner_home, care_at_petsitter_home, dog_walking) FROM stdin;
6	5	all-around petsitter	t	t	t	50.00	t	t	t
8	2	dog walker, experienced	t	t	t	45.00	t	t	t
1	1	Test descriptionaaasss3211	t	t	f	40.00	t	t	f
\.


--
-- Data for Name: petsitter_availability; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.petsitter_availability (id, petsitter_id, date, is_available) FROM stdin;
144	5	2025-01-31	t
145	5	2025-02-01	t
1	1	2025-01-30	f
76	1	2025-03-28	f
77	1	2025-03-29	f
78	1	2025-03-30	f
79	1	2025-03-31	f
80	1	2025-04-01	f
81	1	2025-04-02	f
82	1	2025-04-03	f
18	1	2025-04-04	f
19	1	2025-04-05	f
20	1	2025-04-06	f
21	1	2025-04-07	f
22	1	2025-04-08	f
23	1	2025-04-09	f
24	1	2025-04-10	f
25	1	2025-04-11	f
26	1	2025-04-12	f
27	1	2025-04-13	f
28	1	2025-04-14	f
29	1	2025-04-15	f
30	1	2025-04-16	f
31	1	2025-04-17	f
32	1	2025-04-18	f
33	1	2025-04-19	f
34	1	2025-04-20	f
35	1	2025-04-21	f
36	1	2025-04-22	f
37	1	2025-04-23	f
38	1	2025-04-24	f
39	1	2025-04-25	f
40	1	2025-04-26	f
41	1	2025-04-27	f
42	1	2025-04-28	f
43	1	2025-04-29	f
44	1	2025-04-30	f
45	1	2025-05-01	f
46	1	2025-05-02	f
47	1	2025-05-03	f
48	1	2025-05-04	f
49	1	2025-05-05	f
50	1	2025-05-06	f
51	1	2025-05-07	f
52	1	2025-05-08	f
53	1	2025-05-09	f
54	1	2025-05-10	f
55	1	2025-05-11	f
56	1	2025-05-12	f
57	1	2025-05-13	f
58	1	2025-05-14	f
59	1	2025-05-15	f
60	1	2025-05-16	f
61	1	2025-05-17	f
62	1	2025-05-18	f
63	1	2025-05-19	f
64	1	2025-05-20	f
65	1	2025-05-21	f
66	1	2025-05-22	f
67	1	2025-05-23	f
68	1	2025-05-24	f
69	1	2025-05-25	f
70	1	2025-05-26	f
71	1	2025-05-27	f
72	1	2025-05-28	f
73	1	2025-05-29	f
139	1	2025-05-30	f
140	1	2025-05-31	f
146	5	2025-02-02	t
147	5	2025-02-03	t
148	5	2025-02-04	t
150	5	2025-02-06	t
151	5	2025-02-07	t
152	5	2025-02-08	t
153	5	2025-02-09	t
154	5	2025-02-10	t
155	5	2025-02-11	t
156	5	2025-02-12	t
157	5	2025-02-13	t
158	5	2025-02-14	t
159	2	2025-01-31	t
160	2	2025-02-01	t
161	2	2025-02-02	t
162	2	2025-02-03	t
163	2	2025-02-04	t
164	2	2025-02-05	t
165	2	2025-02-06	t
166	2	2025-02-07	t
167	2	2025-02-08	t
168	2	2025-02-09	t
169	2	2025-02-10	t
170	2	2025-02-11	t
171	2	2025-02-12	t
172	2	2025-02-13	t
4	1	2025-02-02	t
9	1	2025-02-03	t
176	1	2025-02-04	t
177	1	2025-02-05	t
10	1	2025-02-06	t
11	1	2025-02-07	t
12	1	2025-02-08	t
13	1	2025-02-09	t
17	1	2025-02-10	t
183	1	2025-02-11	t
184	1	2025-02-12	t
185	1	2025-02-13	t
186	1	2025-02-14	t
187	1	2025-02-15	t
188	1	2025-02-16	t
189	1	2025-02-17	t
190	1	2025-02-18	t
191	1	2025-02-19	t
192	1	2025-02-20	t
193	1	2025-02-21	t
194	1	2025-02-22	t
195	1	2025-02-23	t
196	1	2025-02-24	t
197	1	2025-02-25	t
198	1	2025-02-26	t
199	1	2025-02-27	t
200	1	2025-02-28	t
2	1	2025-01-31	f
3	1	2025-02-01	f
149	5	2025-02-05	f
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."user" (email, password, id, first_name, last_name, phone, city, street, house_number, apartment_number, postal_code) FROM stdin;
d.kitka@kitkowo.com	$2y$10$UiUyEubJ6vR4VoMSauijT.S33tTeGU3aJ9Nb4ZIalLG/mBS1XaNDi	5	\N	\N	\N	\N	\N	\N	\N	\N
jkowalski@petzone.com	$2y$10$a9UVmr2b4.wn/qm8WiyVzOgHLxPvC06dgYsbbkd3kamHPLdXg4Sly	6	Julie	White	345678912	Krak├│w	D┼éuga	12	4	31-124
johnsmith@email.com	$2y$10$OmKEVRQoqHFHQvXKSabUSuwBbEvuuNJZZjqQESP4CDBbI0tWSJsnG	8	John	Smith	234567891	Krak├│w	D┼éuga	12	4	31-124
alinit@petzone.com	$2y$10$xR0c60KXuHTZqZRcL2WxjOdN/6VU8jX8RyWRoj5w0MdnUWKQ/tbzC	1	Alice	Brown	12345678	Krak├│w	fiolkowa	23a	1111	31-414
emmawilson@email.com	$2y$10$vLykM0rPPYQVwSaPhSKUkuqezt/AOO6LgEfOAsKI7k.ZvTwvBcfHa	9	Emma	Wilson	123456789					
katesnow@email.com	$2y$10$CeIvS0tZGGAhZGhmawLDOuPROhDxwTkhfrD3WHq/xj2lUFVJjXoO6	7	Kate	Snow	321654987	Krak├│w	Karmelicka	21	37	30-255
\.


--
-- Data for Name: visit; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.visit (id, user_id, petsitter_id, care_type, start_date, end_date, confirmed, canceled, pets) FROM stdin;
3	1	1	owner_home	2025-01-31	2025-02-02	f	t	\N
4	6	1	petsitter_home	2025-02-03	2025-02-04	t	f	\N
5	7	1	owner_home	2025-02-05	2025-02-06	t	f	\N
6	7	1	petsitter_home	2025-02-08	2025-02-08	t	f	\N
7	7	1	petsitter_home	2025-02-01	2025-02-01	f	t	\N
8	7	1	owner_home	2025-02-01	2025-02-02	f	f	\N
9	7	1	petsitter_home	2025-01-31	2025-02-01	t	f	{9}
13	9	5	owner_home	2025-02-01	2025-02-03	f	f	{11}
14	8	5	owner_home	2025-02-01	2025-02-02	f	f	{12}
16	8	5	petsitter_home	2025-02-01	2025-02-02	f	f	{12}
17	8	5	petsitter_home	2025-02-01	2025-02-02	f	f	{12}
18	8	5	owner_home	2025-02-01	2025-02-02	f	f	{12}
15	6	1	petsitter_home	2025-02-01	2025-02-02	t	f	{3}
10	7	1	petsitter_home	2025-02-01	2025-02-02	t	f	{9}
12	6	1	owner_home	2025-02-01	2025-02-02	f	t	{3}
11	7	1	owner_home	2025-02-02	2025-02-03	t	f	{9}
19	6	2	owner_home	2025-02-01	2025-02-02	f	f	{3,4}
20	1	5	owner_home	2025-02-01	2025-02-02	f	f	{5}
21	9	2	owner_home	2025-02-01	2025-02-03	f	f	{11}
22	8	5	owner_home	2025-02-01	2025-02-04	f	f	{12}
23	1	2	owner_home	2025-02-01	2025-02-05	f	f	{5}
24	1	1	owner_home	2025-01-31	2025-02-02	t	f	{5}
25	1	1	owner_home	2025-02-01	2025-02-04	f	f	{5}
26	1	5	owner_home	2025-01-31	2025-02-02	f	f	{2}
27	1	5	petsitter_home	2025-02-01	2025-02-04	f	f	{14}
28	9	2	petsitter_home	2025-02-01	2025-02-02	f	f	{10,11}
29	9	1	petsitter_home	2025-02-04	2025-02-05	t	f	{10}
\.


--
-- Name: pet_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.pet_id_seq', 16, true);


--
-- Name: petsitter_availability_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.petsitter_availability_id_seq', 203, true);


--
-- Name: petsitter_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.petsitter_id_seq', 5, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.user_id_seq', 9, true);


--
-- Name: visit_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.visit_id_seq', 29, true);


--
-- Name: pet pet_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.pet
    ADD CONSTRAINT pet_pkey PRIMARY KEY (id);


--
-- Name: petsitter_availability petsitter_availability_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter_availability
    ADD CONSTRAINT petsitter_availability_pkey PRIMARY KEY (id);


--
-- Name: petsitter petsitter_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter
    ADD CONSTRAINT petsitter_pkey PRIMARY KEY (id);


--
-- Name: petsitter_availability unique_petsitter_date; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter_availability
    ADD CONSTRAINT unique_petsitter_date UNIQUE (petsitter_id, date);


--
-- Name: petsitter unique_user_id; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter
    ADD CONSTRAINT unique_user_id UNIQUE (user_id);


--
-- Name: user user_email_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: visit visit_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.visit
    ADD CONSTRAINT visit_pkey PRIMARY KEY (id);


--
-- Name: visit visit_status_trigger; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER visit_status_trigger BEFORE UPDATE ON public.visit FOR EACH ROW EXECUTE FUNCTION public.update_visit_status();


--
-- Name: visit fk_petsitter; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.visit
    ADD CONSTRAINT fk_petsitter FOREIGN KEY (petsitter_id) REFERENCES public.petsitter(id);


--
-- Name: petsitter fk_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter
    ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES public."user"(id);


--
-- Name: visit fk_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.visit
    ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES public."user"(id);


--
-- Name: pet pet_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.pet
    ADD CONSTRAINT pet_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id);


--
-- Name: petsitter_availability petsitter_availability_petsitter_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.petsitter_availability
    ADD CONSTRAINT petsitter_availability_petsitter_id_fkey FOREIGN KEY (petsitter_id) REFERENCES public.petsitter(id);


--
-- PostgreSQL database dump complete
--

