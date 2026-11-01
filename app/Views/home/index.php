<?php
/** OrgSync high-fidelity dashboard, connected to the authenticated PHP session. */
$user = $user ?? ($_SESSION['user'] ?? []);
$dashboardUser = [
  'name' => (string) ($user['full_name'] ?? 'OrgSync User'),
  'role' => (string) ($user['position'] ?? $user['role'] ?? 'Member'),
  'org' => (string) ($user['organization_name'] ?? 'QCU Student Organization'),
  'code' => (string) ($user['org_code'] ?? ''),
  'course' => (string) ($user['course'] ?? ''),
];
?>
<style>
  :root {
    --purple: #6D28D9;
    --purple2: #B35EFE;
    --blue: #5765F2;
    --ink: #242344;
    --muted: #777794;
    --line: #e9e5f6;
    --panel: #fff;
    --bg: #f8f7ff;
    --lav: #F5F3FF;
    --pink: #FCE7F3;
    --mint: #DFF8F0;
    --shadow: 0 10px 30px rgba(82, 59, 155, .08)
  }

  * {
    box-sizing: border-box
  }

  body {
    margin: 0;
    font-family: Inter, "Segoe UI", Arial, sans-serif;
    color: var(--ink);
    background: var(--bg)
  }

  button,
  input,
  select,
  textarea {
    font: inherit
  }

  button {
    cursor: pointer;
    border: 0
  }

  .app {
    display: flex;
    min-height: 100vh
  }

  .sidebar {
    width: 235px;
    flex-shrink: 0;
    padding: 24px 15px;
    position: relative;

    background-color: #FAF7FC;

    background-image:
      radial-gradient(ellipse at 85% 5%,
        rgba(236, 164, 202, 0.65),
        transparent 45%),
      radial-gradient(ellipse at 65% 38%,
        rgba(174, 133, 220, 0.65),
        transparent 50%),
      radial-gradient(ellipse at 10% 65%,
        rgba(190, 170, 230, 0.45),
        transparent 45%),
      radial-gradient(ellipse at 90% 85%,
        rgba(246, 218, 190, 0.55),
        transparent 40%),
      radial-gradient(ellipse at 95% 100%,
        rgba(238, 169, 203, 0.45),
        transparent 35%);

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    border-right: 1px solid #eee8fb;
    display: flex;
    flex-direction: column;
  }

  .brand {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
    padding: 0 9px 30px;
  }

  .brand-image {
    width: 52px;
    height: 52px;
    object-fit: contain;
    flex-shrink: 0;
  }

  .brand-mark {
    width: 42px;
    height: 42px;
    border-radius: 15px;
    background: linear-gradient(135deg, #6b57f2, #c451f0);
    display: grid;
    place-items: center;
    color: #fff;
    font-size: 23px;
    box-shadow: 0 7px 18px #b4a1fa
  }

  .brand-name {
    font-size: 26px;
    font-weight: 850;
    letter-spacing: 0.3px;
    color: #30205B;
    white-space: nowrap;
  }

  .brand-name span {
    color: #8B5CF6;
  }

  .nav {
    display: grid;
    gap: 7px
  }

  .nav button {
    display: flex;
    align-items: center;
    gap: 13px;
    text-align: left;
    padding: 13px 14px;
    border-radius: 12px;
    background: transparent;
    color: #615c83;
    font-size: 15px;
    font-weight: 650;
    transition: .18s;
  }

  .nav button .ico {
    width: 22px;
    text-align: center;
    font-size: 19px;
  }

  .nav button:hover,
  .nav button.active {
    background: linear-gradient(100deg, #ded7ff, #f1dfff);
    color: #5c3bd2;
    box-shadow: 0 5px 14px #cfc1f533
  }

  .side-note {
    margin-top: auto;
    padding: 15px 12px;
    border: 1px solid #e6dcff;
    border-radius: 15px;
    background: #ffffff99;
    color: #706a8c;
    font-size: 12px;
    line-height: 1.5
  }

  .main {
    flex: 1;
    min-width: 0;
    padding: 22px 28px 30px
  }

  .topbar {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 60px display: inline-block;
    border-bottom-width: 2px;
    border-bottom-style: solid;
    border-bottom-color: #ebeaea;
    padding: 50px 20px;
    border-radius: 6px;

  }

  .topbar .profile-text span {
    font-size: 20px;
    font-weight: 600;
    font-weight: bold;
  }

  /* Profile role */
  .topbar .profile-text small {
    font-size: 13px;
  }

  /* Notification icon */
  .topbar .icon-btn {
    font-size: 30px;
  }

  /* Profile avatar */
  .topbar .avatar {
    font-size: 15px;
  }

  .search {
    position: relative;
    flex: 1;
    max-width: 480px
  }

  .search input {
    width: 100%;
    padding: 12px 15px 12px 42px;
    border: 1px solid #eeeaf8;
    border-radius: 13px;
    background: #fff;
    outline: none
  }

  .search:before {
    content: "⌕";
    position: absolute;
    left: 15px;
    top: 6px;
    font-size: 25px;
    color: #8c83b8
  }

  .top-actions {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 17px
  }

  .icon-btn {
    position: relative;
    width: 39px;
    height: 39px;
    border-radius: 13px;
    background: #fff;
    border: 1px solid var(--line);
    color: #7065a0;
    font-size: 18px
  }

  .topbar .logout-btn {
    font-size: 15px;
    padding: 10px 18px;
    min-height: 40px;
    border-radius: 8px;
  }

  .dot {
    position: absolute;
    width: 7px;
    height: 7px;
    background: #f45ca8;
    border-radius: 50%;
    right: 8px;
    top: 7px
  }

  .profile {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 750
  }

  .avatar {
    width: 39px;
    height: 39px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: #fff;
    background: linear-gradient(135deg, #a8a5ff, #f3a4da);
    font-weight: 800
  }

  .profile small {
    display: block;
    color: #8985a2;
    font-weight: 500;
    margin-top: 3px
  }

  .page {
    display: none;
    animation: fade .2s ease
  }

  .page.active {
    display: block
  }

  @keyframes fade {
    from {
      opacity: .45;
      transform: translateY(3px)
    }

    to {
      opacity: 1;
      transform: none
    }
  }

  .page-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 21px
  }

  .page-head h1 {
    font-size: 27px;
    margin: 0 0 7px;
    font-weight: 850;
    letter-spacing: -.6px
  }

  #welcomeTitle {
    background: linear-gradient(135deg, #7547E8, #A855F7, #EC4899);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;

    font-weight: 800;
  }

  .page-head p {
    margin: 0;
    color: var(--muted);
    font-size: 13px
  }

  .upcoming-panel {
    display: flex;
    flex-direction: column;
    min-height: 400px;
  }

  .upcoming-actions {
    margin-top: auto;
    padding-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .upcoming-create,
  .upcoming-schedule {
    display: flex;
    align-items: center;
  }

  .upcoming-create {
    justify-content: flex-start;
  }

  .upcoming-schedule .link-btn {
    justify-content: flex-end;
    font-size: 18px;
    padding: 11px 18px;
    font-weight: 600;
    border-radius: 8px;
    border-color: #242344;

  }

  .btn {
    padding: 11px 50px;
    border-radius: 10px;
    background: linear-gradient(100deg, var(--blue), var(--purple), var(--purple2));
    color: white;
    font-weight: 750;
    box-shadow: 0 5px 14px #9478ed33
  }

  .btn:hover {
    filter: brightness(1.04);
    transform: translateY(-1px)
  }

  .btn.secondary {
    background: #fff;
    color: #6b50d8;
    border: 1px solid #e6defb;
    box-shadow: none
  }

  .btn.danger {
    background: #fff0f4;
    color: #d94c7c;
    box-shadow: none
  }

  .stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 20px
  }

  .stat {
    border: 1px solid var(--line);
    border-radius: 17px;
    padding: 18px;
    background: #fff;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden
  }

  .stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  }

  .stat:after {
    content: "";
    position: absolute;
    width: 85px;
    height: 85px;
    right: -28px;
    bottom: -38px;
    border-radius: 50%;
    background: var(--tint, #eee8ff)
  }

  .stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #7b7799;
    font-size: 12px;
    font-weight: 650
  }

  .stat-icon {
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: var(--tint);
    color: #5267a8;
    font-size: 18px;
  }

  .stat strong {
    display: block;
    font-size: 29px;
    margin-top: 13px;
    position: relative;
    z-index: 1
  }

  .stat small {
    color: #4bba98;
    font-size: 11px;
    display: block;
    margin-top: 4px
  }

  .grid-two {
    display: grid;
    grid-template-columns: minmax(0, 1.55fr) minmax(260px, 1fr);
    gap: 18px align-items: stretch;
  }

  .grid-two>.panel {
    height: 100%;
  }

  .panel {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 17px;
    padding: 19px;
    box-shadow: var(--shadow);
    min-width: 0
  }

  .panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 16px
  }

  .panel-head h2 {
    font-size: 16px;
    margin: 0
  }

  .muted {
    color: var(--muted);
    font-size: 12px
  }

  .link-btn {
    background: none;
    color: #7154df;
    font-weight: 750;
    font-size: 12px
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px
  }

  th {
    text-align: left;
    color: #8c88a4;
    font-size: 11px;
    font-weight: 700;
    padding: 11px 9px;
    border-bottom: 1px solid #f0edf8;
    white-space: nowrap
  }

  td {
    padding: 13px 9px;
    border-bottom: 1px solid #f5f2fb;
    color: #565371
  }

  tr:last-child td {
    border-bottom: 0
  }

  .person {
    display: flex;
    align-items: center;
    gap: 9px;
    white-space: nowrap
  }

  .mini-avatar {
    width: 29px;
    height: 29px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    background: #eee8ff;
    color: #7352df;
    font-weight: 800
  }

  .pill {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 750;
    background: #e2f8ef;
    color: #2b9b78
  }

  .pill.pending {
    background: #fff2d8;
    color: #bb8431
  }

  .pill.cancelled,
  .pill.absent {
    background: #ffe7ef;
    color: #d85b83
  }

  .pill.late {
    background: #eee8ff;
    color: #7655d9
  }

  .event-list {
    display: grid;
    gap: 12px
  }

  .event-row {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 12px;
    border: 1px solid #f0ecfa;
    border-radius: 13px
  }

  .datebox {
    width: 47px;
    min-width: 47px;
    height: 51px;
    border-radius: 12px;
    background: #f0ebff;
    color: #7351df;
    display: grid;
    align-content: center;
    text-align: center
  }

  .datebox b {
    font-size: 17px
  }

  .datebox small {
    font-size: 10px
  }

  .event-info {
    min-width: 0;
    flex: 1
  }

  .event-info b {
    font-size: 12px;
    display: block;
    margin-bottom: 5px
  }

  .event-info small {
    font-size: 11px;
    color: #8a86a1
  }

  .event-row .pill {
    white-space: nowrap
  }

  .quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px
  }

  .quick {
    padding: 15px;
    border-radius: 13px;
    background: #faf8ff;
    border: 1px solid #eee8ff;
    text-align: left;
    color: #5c4c91;
    font-weight: 750
  }

  .quick span {
    display: block;
    font-size: 22px;
    margin-bottom: 9px
  }

  .quick small {
    display: block;
    font-weight: 500;
    color: #8c87a5;
    margin-top: 4px
  }

  .toolbar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px
  }

  .toolbar input,
  .toolbar select,
  .field input,
  .field select,
  .field textarea {
    border: 1px solid #e8e3f5;
    border-radius: 10px;
    padding: 11px 12px;
    background: #fff;
    outline: none;
    color: var(--ink)
  }

  .toolbar input {
    min-width: 220px;
    flex: 1
  }

  .table-wrap {
    overflow: auto
  }

  .empty {
    text-align: center;
    padding: 35px;
    color: #9691ae;
    font-size: 13px
  }

  .schedule-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.8fr) minmax(230px, .8fr);
    gap: 18px
  }

  .calendar-tools {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px
  }

  .calendar {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    border-top: 1px solid #eeeaf7;
    border-left: 1px solid #eeeaf7
  }

  .day-head,
  .day {
    padding: 8px;
    border-right: 1px solid #eeeaf7;
    border-bottom: 1px solid #eeeaf7;
    min-height: 76px;
    font-size: 11px
  }

  .day-head {
    text-align: center;
    color: #8b86a5;
    background: #faf9ff;
    min-height: auto;
    font-weight: 750
  }

  .day .num {
    font-weight: 750;
    color: #5c567a
  }

  .day.today {
    background: #f3efff
  }

  .cal-event {
    display: block;
    margin-top: 5px;
    padding: 4px;
    border-radius: 5px;
    background: #e9e2ff;
    color: #6b4bd5;
    font-size: 9px;
    overflow: hidden
  }

  .avail-grid {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 5px
  }

  .avail-cell {
    height: 30px;
    border-radius: 6px;
    background: #e7e2ff;
    cursor: pointer
  }

  .avail-cell.off {
    background: #f5f3fa
  }

  .avail-cell:hover {
    outline: 2px solid #a28af4
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px
  }

  .field {
    display: grid;
    gap: 7px
  }

  .field label {
    font-size: 12px;
    color: #6f6a8d;
    font-weight: 750
  }

  .field.full {
    grid-column: 1/-1
  }

  .field textarea {
    min-height: 85px;
    resize: vertical
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    margin-top: 18px
  }

  .settings-list {
    display: grid;
    gap: 10px
  }

  .setting-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 15px;
    border: 1px solid #eeeaf7;
    border-radius: 13px
  }

  .setting-row b {
    display: block;
    font-size: 13px;
    margin-bottom: 5px
  }

  .setting-row small {
    color: #8c87a5
  }

  .toggle {
    width: 42px;
    height: 24px;
    background: #dcd7ec;
    border-radius: 20px;
    padding: 3px;
    cursor: pointer
  }

  .toggle:after {
    content: "";
    display: block;
    width: 18px;
    height: 18px;
    background: white;
    border-radius: 50%;
    transition: .2s
  }

  .toggle.on {
    background: #8c67f0
  }

  .toggle.on:after {
    transform: translateX(18px)
  }

  .toast {
    position: fixed;
    right: 22px;
    bottom: 22px;
    padding: 13px 17px;
    background: #29234b;
    color: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    z-index: 20;
    display: none;
    font-size: 13px
  }

  .modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: #29204455;
    z-index: 30;
    align-items: center;
    justify-content: center;
    padding: 20px
  }

  .modal-backdrop.show {
    display: flex
  }

  .modal {
    width: min(560px, 100%);
    max-height: 90vh;
    overflow: auto;
    background: #fff;
    border-radius: 19px;
    padding: 23px;
    box-shadow: 0 25px 70px #30205b33
  }

  .modal h2 {
    margin: 0 0 18px;
    font-size: 20px
  }

  .modal-close {
    float: right;
    background: #f4f0ff;
    border-radius: 9px;
    padding: 6px 10px;
    color: #6b50d8
  }

  .mobile-menu {
    display: none
  }

  @media(max-width:1050px) {
    .sidebar {
      width: 205px
    }

    .main {
      padding: 20px
    }

    .stats {
      grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .grid-two,
    .schedule-layout {
      grid-template-columns: 1fr
    }
  }

  @media(max-width:720px) {
    .app {
      display: block
    }

    .sidebar {
      width: 100%;
      padding: 12px;
      display: block
    }

    .brand {
      padding: 0 7px 12px
    }

    .side-note {
      display: none
    }

    .nav {
      display: flex;
      overflow: auto;
      gap: 5px
    }

    .nav button {
      white-space: nowrap;
      padding: 10px
    }

    .nav button .ico {
      width: auto
    }

    .main {
      padding: 16px
    }

    .topbar {
      margin-bottom: 18px
    }

    .profile .profile-text {
      display: none
    }

    .page-head h1 {
      font-size: 23px
    }

    .stats {
      gap: 9px
    }

    .stat {
      padding: 13px
    }

    .stat strong {
      font-size: 24px
    }

    .grid-two {
      gap: 12px
    }

    .panel {
      padding: 14px
    }

    .form-grid {
      grid-template-columns: 1fr
    }

    .field.full {
      grid-column: auto
    }

    .day {
      min-height: 57px;
      padding: 5px
    }

    .cal-event {
      font-size: 8px
    }

    .search {
      max-width: none
    }

    .top-actions {
      gap: 7px
    }
  }

  /* Shared OrgSync registration theme */
  :root {
    --purple: #6D28D9;
    --purple2: #B35EFE;
    --blue: #5765F2;
    --bg: #F8F7FF;
    --line: #E4DCFD
  }

  .btn,
  .brand-mark {
    background-image: linear-gradient(90deg, #5765F2 0%, #8A57FE 50%, #B35EFE 100%)
  }

  .btn.secondary {
    background: #fff;
    background-image: none
  }

  .logout-btn {
    white-space: nowrap;
    text-decoration: none;
    font-size: 12px;
    padding: 9px 12px
  }

  .profile {
    min-width: 0
  }

  .top-actions {
    flex-wrap: wrap
  }

  @media(max-width:720px) {
    .logout-btn {
      padding: 8px 10px;
      font-size: 11px
    }

    .top-actions {
      margin-left: 0
    }

    .topbar {
      flex-wrap: wrap
    }
  }
</style>
<div class="app">
  <aside class="sidebar">
    <div class="brand">
      <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="OrgSync Logo" class="brand-image">

      <div class="brand-name">
        ORG<span>SYNC</span>
      </div>
    </div>
    <nav class="nav" aria-label="Main navigation">
      <button class="active" data-page="dashboard">
        <span class="ico"><i class="fa-solid fa-house"></i></span>
        Home
      </button>

      <button data-page="members">
        <span class="ico"><i class="fa-solid fa-users"></i></span>
        Members
      </button>

      <button data-page="schedules">
        <span class="ico"><i class="fa-solid fa-calendar-days"></i></span>
        Schedules
      </button>

      <button data-page="events">
        <span class="ico"><i class="fa-solid fa-calendar-check"></i></span>
        Events
      </button>

      <button data-page="attendance">
        <span class="ico"><i class="fa-solid fa-clipboard-check"></i></span>
        Attendance
      </button>

      <button data-page="settings">
        <span class="ico"><i class="fa-solid fa-gear"></i></span>
        Settings
      </button>
    </nav>
    <div class="side-note"><b>OrgSync Workspace</b><br>Plan. Collaborate. Achieve.<br><span id="sideOrg">Student
        Organization</span></div>
  </aside>

  <main class="main">
    <header class="topbar">
      <div class="search"><input id="globalSearch" placeholder="Search members, events..." aria-label="Search"></div>
      <div class="top-actions">
        <a class="btn secondary logout-btn" href="<?= BASE_URL ?>/logout" title="Log out">↪ Log out</a>
        <button class="icon-btn" id="notificationBtn" title="Notifications">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
          <i class="fa-regular fa-bell"></i>
          <span class="dot"></span>
        </button>
        <div class="profile">
          <div class="avatar" id="avatar">OP</div>
          <div class="profile-text"><span id="profileName">Organization President</span><small id="profileRole">OrgSync
              Admin</small></div>⌄
        </div>
      </div>
    </header>

    <section class="page active" id="page-dashboard">
      <div class="page-head">
        <div>
          <<h1><span id="welcomeTitle">Organization President</span></h1>
            <p>Here's what's happening with your organization today.</p>
        </div>

      </div>
      <div class="stats">
        <div class="stat" style="--tint:#e7efff">
          <div class="stat-top">
            Total Members
            <span class="stat-icon">
              <i class="fa-solid fa-users"></i>
            </span>
          </div>
          <strong id="statMembers">0</strong>
          <small>Registered organization members</small>
        </div>

        <div class="stat" style="--tint:#efe7ff">
          <div class="stat-top">
            Upcoming Events
            <span class="stat-icon">
              <i class="fa-solid fa-calendar-days"></i>
            </span>
          </div>
          <strong id="statEvents">0</strong>
          <small>Within the next 7 days</small>
        </div>

        <div class="stat" style="--tint:#ffe8f8">
          <div class="stat-top">
            Active Officers
            <span class="stat-icon">
              <i class="fa-solid fa-user-tie"></i>
            </span>
          </div>
          <strong id="statOfficers">0</strong>
          <small>President, officers and leaders</small>
        </div>

        <div class="stat" style="--tint:#dcf8ee">
          <div class="stat-top">
            Attendance Records
            <span class="stat-icon">
              <i class="fa-solid fa-clipboard-check"></i>
            </span>
          </div>
          <strong id="statAttendance">0</strong>
          <small>Records saved in OrgSync</small>
        </div>
      </div>

      <div class="grid-two">

        <!-- UPCOMING EVENTS PANEL -->
        <div class="panel upcoming-panel">

          <!-- Your upcoming events content -->
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>EVENT NAME</th>
                  <th>DATE</th>
                  <th>VENUE</th>
                  <th>STATUS</th>
                </tr>
              </thead>
              <tbody id="dashboardEvents"></tbody>
            </table>
          </div>

          <!-- Empty Message -->
          <div id="dashboardEventsEmpty" class="empty">
            No events yet. Create your first event.
          </div>

          <div class="upcoming-actions">
            <div class="upcoming-create">
              <button class="btn" data-action="add-event">
                <i class="fa-solid fa-plus"></i>
                Create Event
              </button>
            </div>

            <div class="upcoming-schedule">
              <button class="link-btn" data-goto="schedules">
                <i class="fa-solid fa-calendar-check"></i>
                View Schedule →
              </button>
            </div>
          </div>

        </div>



        <!-- QUICK ACTIONS PANEL -->
        <div class="panel">

          <div class="panel-head">
            <h2>
              <i class="fa-solid fa-bolt"></i>
              Quick Actions
            </h2>
            <span class="muted">Manage faster</span>
          </div>

          <div class="quick-actions">

            <button class="quick" data-action="add-member">
              <span><i class="fa-solid fa-user-plus"></i></span>
              Add Members
              <small>Register a member</small>
            </button>

            <button class="quick" data-action="add-event">
              <span><i class="fa-solid fa-calendar-plus"></i></span>
              Create Event
              <small>Plan an activity</small>
            </button>

            <button class="quick" data-goto="schedules">
              <span><i class="fa-solid fa-calendar-days"></i></span>
              Schedules
              <small>Check availability</small>
            </button>

            <button class="quick" data-goto="attendance">
              <span><i class="fa-solid fa-clipboard-check"></i></span>
              Attendance
              <small>Record participation</small>
            </button>

          </div>

          <!-- RECENT NOTIFICATIONS -->
          <div class="panel-head" style="margin-top:23px">
            <h2>
              <i class="fa-solid fa-bell"></i>
              Recent Notifications
            </h2>

            <button class="link-btn" data-goto="notifications">
              View all →
            </button>
          </div>

          <div id="recentNotices" class="event-list"></div>

        </div>

      </div>
    </section>

    <section class="page" id="page-members">
      <div class="page-head">
        <div>
          <h1>Members</h1>
          <p>Manage your organization's members, roles, and membership status.</p>
        </div>
      </div>
      <div class="stats" style="--tint:#e7efff">

        <!-- Total Members -->
        <div class="stat">
          <div class="stat-top">
            Total Members
            <span class="stat-icon">
              <i class="fa-solid fa-users"></i>
            </span>
          </div>
          <strong id="memberTotal">0</strong>
        </div>

        <!-- Officers -->
        <div class="stat">
          <div class="stat-top">
            Officers
            <span class="stat-icon">
              <i class="fa-solid fa-user-tie"></i>
            </span>
          </div>
          <strong id="memberOfficerTotal">0</strong>
        </div>

        <!-- Active Members -->
        <div class="stat">
          <div class="stat-top">
            Active Members
            <span class="stat-icon">
              <i class="fa-solid fa-user-check"></i>
            </span>
          </div>
          <strong id="memberActiveTotal">0</strong>
        </div>

        <!-- Pending -->
        <div class="stat">
          <div class="stat-top">
            Pending
            <span class="stat-icon">
              <i class="fa-solid fa-clock"></i>
            </span>
          </div>
          <strong id="memberPendingTotal">0</strong>
        </div>

      </div>
      <div class="panel">
        <div class="toolbar"><input id="memberSearch" placeholder="Search member name..."><select id="memberRoleFilter">
            <option value="">All roles</option>
            <option>President</option>
            <option>Vice President</option>
            <option>Secretary</option>
            <option>Treasurer</option>
            <option>Officer</option>
            <option>Member</option>
          </select><select id="memberStatusFilter">
            <option value="">All statuses</option>
            <option>Active</option>
            <option>Pending</option>
            <option>Inactive</option>
          </select>
          <button class="btn" data-action="add-member">＋ Add Member</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>MEMBER</th>
                <th>ROLE</th>
                <th>COURSE / YEAR</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="membersTable"></tbody>
          </table>
        </div>
        <div id="membersEmpty" class="empty">No members match your search.</div>
      </div>
    </section>

    <section class="page" id="page-schedules">
      <div class="page-head">
        <div>
          <h1>Schedule & Availability</h1>
          <p>View organization activities and record member availability.</p>
        </div><button class="btn" data-action="add-availability">＋ Add Availability</button>
      </div>
      <div class="schedule-layout">
        <div class="panel">
          <div class="calendar-tools"><button class="btn secondary" id="prevMonth">←</button><b id="calendarTitle">Month
              Year</b><button class="btn secondary" id="nextMonth">→</button></div>
          <div id="calendar" class="calendar"></div>
        </div>
        <div class="panel">
          <div class="panel-head">
            <h2>Availability Records</h2>
          </div>
          <div id="availabilityList" class="event-list"></div>
          <div id="availabilityEmpty" class="empty">No availability records yet.</div>
          <hr style="border:0;border-top:1px solid #eeeaf7;margin:20px 0">
          <h3 style="font-size:14px">Schedule Conflict Check</h3>
          <p class="muted">OrgSync flags overlapping events and availability that does not cover an event's full time.
          </p><button class="btn secondary" id="checkConflicts">Check Event Conflicts</button>
          <div id="conflictResults" class="muted" style="margin-top:12px"></div>
        </div>
      </div>
    </section>

    <section class="page" id="page-events">
      <div class="page-head">
        <div>
          <h1>Events</h1>
          <p>Create, manage, and track your organization's activities.</p>
        </div><button class="btn" data-action="add-event">＋ Create Event</button>
      </div>
      <div class="panel">
        <div class="toolbar"><input id="eventSearch" placeholder="Search event name..."><select id="eventStatusFilter">
            <option value="">All events</option>
            <option>Upcoming</option>
            <option>Past</option>
          </select><select id="eventPriorityFilter">
            <option value="">All priorities</option>
            <option>Normal</option>
            <option>High</option>
            <option>Critical</option>
          </select></div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>EVENT</th>
                <th>DATE & TIME</th>
                <th>VENUE</th>
                <th>PRIORITY</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="eventsTable"></tbody>
          </table>
        </div>
        <div id="eventsEmpty" class="empty">No events found. Create an event to get started.</div>
      </div>
    </section>

    <section class="page" id="page-attendance">
      <div class="page-head">
        <div>
          <h1>Attendance</h1>
          <p>Record attendance and review participation in organization events.</p>
        </div><button class="btn" data-action="record-attendance">＋ Record Attendance</button>
      </div>
      <div class="stats" style="--tint:#e7efff">
        <div class="stat">
          <div class="stat-top">Total Records</div><strong id="attTotal">0</strong>
        </div>
        <div class="stat">
          <div class="stat-top">Present</div><strong id="attPresent">0</strong>
        </div>
        <div class="stat">
          <div class="stat-top">Absent</div><strong id="attAbsent">0</strong>
        </div>
        <div class="stat">
          <div class="stat-top">Late / Excused</div><strong id="attOther">0</strong>
        </div>
      </div>
      <div class="panel">
        <div class="toolbar"><input id="attendanceSearch" placeholder="Search event or member..."><select
            id="attendanceEventFilter">
            <option value="">All events</option>
          </select></div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>EVENT</th>
                <th>MEMBER</th>
                <th>STATUS</th>
                <th>RECORDED AT</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="attendanceTable"></tbody>
          </table>
        </div>
        <div id="attendanceEmpty" class="empty">No attendance records yet.</div>
      </div>
    </section>

    <section class="page" id="page-notifications">
      <div class="page-head">
        <div>
          <h1>Notifications</h1>
          <p>Reminders about activities, schedule changes, and deadlines.</p>
        </div><button class="btn secondary" id="generateReminders">Generate Reminders</button>
      </div>
      <div class="panel">
        <div class="panel-head">
          <h2>All Notifications</h2><button class="btn danger" id="clearNotifications">Clear all</button>
        </div>
        <div id="noticeList" class="event-list"></div>
        <div id="noticeEmpty" class="empty">You're all caught up. No notifications yet.</div>
      </div>
    </section>

    <section class="page" id="page-settings">
      <div class="page-head">
        <div>
          <h1>Settings</h1>
          <p>Manage your profile, organization information, and notification preferences.</p>
        </div>
      </div>
      <div class="grid-two">
        <div class="panel">
          <div class="panel-head">
            <h2>Profile Information</h2>
          </div>
          <form id="settingsForm">
            <div class="form-grid">
              <div class="field"><label for="settingsName">Full name</label><input id="settingsName" required></div>
              <div class="field"><label for="settingsRole">Role</label><select id="settingsRole">
                  <option>Organization President</option>
                  <option>Officer</option>
                  <option>Member</option>
                </select></div>
              <div class="field full"><label for="settingsOrg">Organization name</label><input id="settingsOrg"
                  required></div>
              <div class="field full"><label for="settingsCode">Organization code</label><input id="settingsCode"
                  placeholder="e.g. QCU-ORG-001"></div>
            </div>
            <div class="form-actions"><button class="btn" type="submit">Save Changes</button></div>
          </form>
        </div>
        <div class="panel">
          <div class="panel-head">
            <h2>Notification Preferences</h2>
          </div>
          <div class="settings-list">
            <div class="setting-row">
              <div><b>Upcoming event reminders</b><small>Show reminders for upcoming activities.</small></div><button
                class="toggle on" data-toggle="reminders" aria-label="Toggle reminders"></button>
            </div>
            <div class="setting-row">
              <div><b>Schedule conflict alerts</b><small>Notify when events overlap.</small></div><button
                class="toggle on" data-toggle="conflicts" aria-label="Toggle conflict alerts"></button>
            </div>
            <div class="setting-row">
              <div><b>Attendance updates</b><small>Notify when attendance is recorded.</small></div><button
                class="toggle on" data-toggle="attendance" aria-label="Toggle attendance updates"></button>
            </div>
          </div>
          <hr style="border:0;border-top:1px solid #eeeaf7;margin:20px 0"><button class="btn secondary"
            id="exportData">Export data as JSON</button> <button class="btn danger" id="resetData">Reset demo
            data</button>
          <p class="muted">Your account uses the OrgSync login system. Dashboard activity records are saved in this
            browser on this device.</p>
        </div>
      </div>
    </section>
  </main>
</div>
<div class="toast" id="toast"></div>
<div class="modal-backdrop" id="modalBackdrop">
  <div class="modal"><button class="modal-close" id="modalClose">✕</button>
    <h2 id="modalTitle">Add record</h2>
    <form id="modalForm">
      <div id="modalFields" class="form-grid"></div>
      <div class="form-actions"><button type="button" class="btn secondary" id="modalCancel">Cancel</button><button
          type="submit" class="btn">Save</button></div>
    </form>
  </div>
</div>
<script>
  window.ORG_SYNC_USER = {
    name: <?= json_encode($dashboardUser['name'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>,
    role: <?= json_encode($dashboardUser['role'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>,
    org: <?= json_encode($dashboardUser['org'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>,
    code: <?= json_encode($dashboardUser['code'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>,
    course: <?= json_encode($dashboardUser['course'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>
  };
</script>
<script>

  const STORAGE_KEY = 'orgsync_high_fidelity_v1';
  const todayISO = () => new Date().toISOString().slice(0, 10);
  const addDays = (n) => { const d = new Date(); d.setDate(d.getDate() + n); return d.toISOString().slice(0, 10) };
  const defaultData = {
    profile: { name: 'Organization President', role: 'Organization President', org: 'QCU Student Organization', code: 'QCU-ORG-001' },
    members: [
      { id: 1, name: 'Franz Michael Balboa', role: 'Officer', course: 'BSIS - 3A', status: 'Active' },
      { id: 2, name: 'Ella Mae Ignacio', role: 'Member', course: 'BSIS - 3A', status: 'Active' },
      { id: 3, name: 'Zephaniah Ernesto', role: 'Secretary', course: 'BSIS - 3A', status: 'Active' },
      { id: 4, name: 'Shiella Marie Fodulla', role: 'Member', course: 'BSIS - 3A', status: 'Pending' },
      { id: 5, name: 'Frank Cabaltera', role: 'Vice President', course: 'BSIS - 3A', status: 'Active' }
    ],
    events: [
      { id: 1, name: 'General Assembly', date: addDays(2), start: '09:00', end: '11:00', venue: 'QCU Main Hall', priority: 'High', status: 'Approved', description: 'Organization-wide meeting' },
      { id: 2, name: 'Community Outreach Program', date: addDays(4), start: '13:00', end: '15:00', venue: 'Community Center', priority: 'Normal', status: 'Approved', description: 'Community service activity' },
      { id: 3, name: 'Planning Meeting', date: addDays(6), start: '10:00', end: '11:00', venue: 'Room 101', priority: 'Normal', status: 'Pending', description: 'Planning for upcoming projects' }
    ],
    availability: [], attendance: [], notices: [], preferences: { reminders: true, conflicts: true, attendance: true }, nextId: 6
  };
  let data;
  try { data = JSON.parse(localStorage.getItem(STORAGE_KEY)) || structuredClone(defaultData) } catch (e) { data = structuredClone(defaultData) }
  if (!data.profile) data.profile = structuredClone(defaultData.profile);
  // Sync the signed-in PHP account into the dashboard profile.
  if (window.ORG_SYNC_USER) { data.profile = { ...data.profile, ...window.ORG_SYNC_USER }; }
  ['members', 'events', 'availability', 'attendance', 'notices'].forEach(k => { if (!Array.isArray(data[k])) data[k] = [] });
  if (!data.preferences) data.preferences = { reminders: true, conflicts: true, attendance: true };
  let currentMonth = new Date(); let modalType = null;
  const $ = id => document.getElementById(id);
  const escapeHTML = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const save = () => localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
  const dateObj = s => new Date(s + 'T12:00:00');
  const fmtDate = s => s ? dateObj(s).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
  const initials = s => (s || 'U').split(/\s+/).slice(0, 2).map(x => x[0]).join('').toUpperCase();
  const isUpcoming = e => e.date >= todayISO();
  function toast(message) { const t = $('toast'); t.textContent = message; t.style.display = 'block'; clearTimeout(toast.timer); toast.timer = setTimeout(() => t.style.display = 'none', 2800) }
  function addNotice(message) { data.notices.unshift({ id: Date.now() + Math.random(), message, created: new Date().toLocaleString() }); data.notices = data.notices.slice(0, 100) }
  function badge(status) { const cls = String(status).toLowerCase().replace(/\s+/g, ''); return `<span class="pill ${['pending', 'absent', 'late', 'excused', 'inactive'].includes(cls) ? cls : ''}">${escapeHTML(status)}</span>` }
  function showPage(page) { document.querySelectorAll('.page').forEach(p => p.classList.toggle('active', p.id === 'page-' + page)); document.querySelectorAll('.nav button').forEach(b => b.classList.toggle('active', b.dataset.page === page)); if (page === 'schedules') renderCalendar(); window.scrollTo({ top: 0, behavior: 'smooth' }) }
  document.querySelectorAll('.nav button').forEach(b => b.addEventListener('click', () => showPage(b.dataset.page)));
  document.addEventListener('click', e => { const goto = e.target.closest('[data-goto]'); if (goto) showPage(goto.dataset.goto); const act = e.target.closest('[data-action]'); if (act) openModal(act.dataset.action) });
  $('notificationBtn').addEventListener('click', () => showPage('notifications'));
  function render() {
    $('profileName').textContent = data.profile.name; $('profileRole').textContent = data.profile.role; $('avatar').textContent = initials(data.profile.name); $('welcomeTitle').textContent = 'Hi, ' + data.profile.name + '!'; $('sideOrg').textContent = data.profile.org;
    const upcoming = data.events.filter(isUpcoming);
    $('statMembers').textContent = data.members.length; $('statEvents').textContent = upcoming.length; $('statOfficers').textContent = data.members.filter(m => m.role !== 'Member' && m.status === 'Active').length; $('statAttendance').textContent = data.attendance.length;
    $('memberTotal').textContent = data.members.length; $('memberOfficerTotal').textContent = data.members.filter(m => m.role !== 'Member').length; $('memberActiveTotal').textContent = data.members.filter(m => m.status === 'Active').length; $('memberPendingTotal').textContent = data.members.filter(m => m.status === 'Pending').length;
    $('attTotal').textContent = data.attendance.length; $('attPresent').textContent = data.attendance.filter(a => a.status === 'Present').length; $('attAbsent').textContent = data.attendance.filter(a => a.status === 'Absent').length; $('attOther').textContent = data.attendance.filter(a => ['Late', 'Excused'].includes(a.status)).length;
    renderDashboardEvents(); renderMembers(); renderEvents(); renderAvailability(); renderAttendance(); renderNotices(); renderCalendar(); renderAttendanceFilter(); syncSettings(); save();
  }
  function renderDashboardEvents() { const list = [...data.events].filter(isUpcoming).sort((a, b) => a.date.localeCompare(b.date)).slice(0, 5); $('dashboardEvents').innerHTML = list.map(e => `<tr><td><b>${escapeHTML(e.name)}</b></td><td>${fmtDate(e.date)}</td><td>${escapeHTML(e.venue || '—')}</td><td>${badge(e.status)}</td></tr>`).join(''); $('dashboardEventsEmpty').style.display = list.length ? 'none' : 'block'; $('recentNotices').innerHTML = data.notices.slice(0, 3).map(n => `<div class="event-row"><div class="datebox">♧</div><div class="event-info"><b>${escapeHTML(n.message)}</b><small>${escapeHTML(n.created)}</small></div></div>`).join('') || '<div class="muted">No recent notifications.</div>' }
  function renderMembers() { const q = ($('memberSearch')?.value || $('globalSearch').value).toLowerCase(); const role = $('memberRoleFilter').value, status = $('memberStatusFilter').value; const rows = data.members.filter(m => (!q || `${m.name} ${m.course} ${m.role}`.toLowerCase().includes(q)) && (!role || m.role === role) && (!status || m.status === status)); $('membersTable').innerHTML = rows.map(m => `<tr><td><div class="person"><div class="mini-avatar">${initials(m.name)}</div><b>${escapeHTML(m.name)}</b></div></td><td>${escapeHTML(m.role)}</td><td>${escapeHTML(m.course || '—')}</td><td>${badge(m.status)}</td><td><button class="link-btn" data-edit-member="${m.id}">Edit</button> <button class="link-btn" data-delete-member="${m.id}">Remove</button></td></tr>`).join(''); $('membersEmpty').style.display = rows.length ? 'none' : 'block' }
  function renderEvents() { const q = ($('eventSearch')?.value || $('globalSearch').value).toLowerCase(), status = $('eventStatusFilter').value, priority = $('eventPriorityFilter').value; const rows = data.events.filter(e => (!q || `${e.name} ${e.venue}`.toLowerCase().includes(q)) && (!status || (status === 'Upcoming' ? isUpcoming(e) : !isUpcoming(e))) && (!priority || e.priority === priority)).sort((a, b) => a.date.localeCompare(b.date)); $('eventsTable').innerHTML = rows.map(e => `<tr><td><b>${escapeHTML(e.name)}</b><div class="muted">${escapeHTML(e.description || '')}</div></td><td>${fmtDate(e.date)}<div class="muted">${escapeHTML(e.start)}–${escapeHTML(e.end)}</div></td><td>${escapeHTML(e.venue || '—')}</td><td>${badge(e.priority)}</td><td><button class="link-btn" data-check-event="${e.id}">Check</button> <button class="link-btn" data-delete-event="${e.id}">Delete</button></td></tr>`).join(''); $('eventsEmpty').style.display = rows.length ? 'none' : 'block' }
  function renderAvailability() { $('availabilityList').innerHTML = data.availability.map(a => `<div class="event-row"><div class="datebox"><b>${dateObj(a.date).getDate()}</b><small>${dateObj(a.date).toLocaleDateString(undefined, { month: 'short' })}</small></div><div class="event-info"><b>${escapeHTML(a.member)}</b><small>${fmtDate(a.date)} · ${escapeHTML(a.from)}–${escapeHTML(a.until)}</small></div><button class="link-btn" data-delete-availability="${a.id}">×</button></div>`).join(''); $('availabilityEmpty').style.display = data.availability.length ? 'none' : 'block' }
  function renderAttendance() { const q = ($('attendanceSearch')?.value || '').toLowerCase(), ev = $('attendanceEventFilter').value; const rows = data.attendance.filter(a => (!q || `${a.event} ${a.member}`.toLowerCase().includes(q)) && (!ev || a.event === ev)); $('attendanceTable').innerHTML = rows.map(a => `<tr><td>${escapeHTML(a.event)}</td><td>${escapeHTML(a.member)}</td><td>${badge(a.status)}</td><td>${escapeHTML(a.created)}</td><td><button class="link-btn" data-delete-attendance="${a.id}">Remove</button></td></tr>`).join(''); $('attendanceEmpty').style.display = rows.length ? 'none' : 'block' }
  function renderAttendanceFilter() { const select = $('attendanceEventFilter'), old = select.value; select.innerHTML = '<option value="">All events</option>' + data.events.map(e => `<option>${escapeHTML(e.name)}</option>`).join(''); select.value = old }
  function renderNotices() { $('noticeList').innerHTML = data.notices.map(n => `<div class="event-row"><div class="datebox">♧</div><div class="event-info"><b>${escapeHTML(n.message)}</b><small>${escapeHTML(n.created)}</small></div><button class="link-btn" data-delete-notice="${n.id}">Dismiss</button></div>`).join(''); $('noticeEmpty').style.display = data.notices.length ? 'none' : 'block' }
  function renderCalendar() { const y = currentMonth.getFullYear(), m = currentMonth.getMonth(); $('calendarTitle').textContent = currentMonth.toLocaleDateString(undefined, { month: 'long', year: 'numeric' }); const first = new Date(y, m, 1), start = (first.getDay() + 6) % 7, days = new Date(y, m + 1, 0).getDate(); let out = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].map(d => `<div class="day-head">${d}</div>`).join(''); for (let i = 0; i < start; i++)out += '<div class="day"></div>'; for (let d = 1; d <= days; d++) { const iso = `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`, events = data.events.filter(e => e.date === iso); out += `<div class="day ${iso === todayISO() ? 'today' : ''}"><span class="num">${d}</span>${events.map(e => `<span class="cal-event" title="${escapeHTML(e.name)}">${escapeHTML(e.name)}</span>`).join('')}</div>` } $('calendar').innerHTML = out }
  function syncSettings() { $('settingsName').value = data.profile.name; $('settingsRole').value = data.profile.role; $('settingsOrg').value = data.profile.org; $('settingsCode').value = data.profile.code || ''; document.querySelectorAll('[data-toggle]').forEach(b => b.classList.toggle('on', !!data.preferences[b.dataset.toggle])) }
  $('prevMonth').addEventListener('click', () => { currentMonth.setMonth(currentMonth.getMonth() - 1); renderCalendar() }); $('nextMonth').addEventListener('click', () => { currentMonth.setMonth(currentMonth.getMonth() + 1); renderCalendar() });
  ['memberSearch', 'memberRoleFilter', 'memberStatusFilter'].forEach(id => $(id).addEventListener('input', renderMembers));['eventSearch', 'eventStatusFilter', 'eventPriorityFilter'].forEach(id => $(id).addEventListener('input', renderEvents));['attendanceSearch', 'attendanceEventFilter'].forEach(id => $(id).addEventListener('input', renderAttendance));
  $('globalSearch').addEventListener('input', () => { const active = document.querySelector('.page.active')?.id; if (active === 'page-members') renderMembers(); else if (active === 'page-events') renderEvents(); else if ($('globalSearch').value.trim()) { showPage('members'); renderMembers() } });
  function field(name, label, type = 'text', required = true, options = []) { let input = ''; if (type === 'select') input = `<select name="${name}" ${required ? 'required' : ''}>${options.map(o => `<option>${escapeHTML(o)}</option>`).join('')}</select>`; else input = `<input name="${name}" type="${type}" ${required ? 'required' : ''} ${type === 'time' ? 'step="60"' : ''}>`; return `<div class="field"><label>${label}</label>${input}</div>` }
  function openModal(type, record = null) {
    modalType = type; const fields = $('modalFields'); let title = 'Add record', body = '';
    if (type === 'add-member' || type === 'edit-member') { title = type === 'edit-member' ? 'Edit Member' : 'Add Member'; body = field('name', 'Full name') + field('role', 'Role', 'select', true, ['Member', 'Officer', 'President', 'Vice President', 'Secretary', 'Treasurer']) + field('course', 'Course / Year', 'text', false) + field('status', 'Membership status', 'select', true, ['Active', 'Pending', 'Inactive']); }
    if (type === 'add-event') { title = 'Create Event'; body = field('name', 'Event name') + field('date', 'Date', 'date') + field('start', 'Start time', 'time') + field('end', 'End time', 'time') + field('venue', 'Venue', 'text', false) + field('priority', 'Priority', 'select', true, ['Normal', 'High', 'Critical']) + '<div class="field full"><label>Description</label><textarea name="description" placeholder="Describe the activity"></textarea></div>' }
    if (type === 'add-availability') { title = 'Add Availability'; body = field('member', 'Member', 'select', true, data.members.map(m => m.name)) + field('date', 'Date', 'date') + field('from', 'Available from', 'time') + field('until', 'Available until', 'time') + '<div class="field full"><label>Notes</label><input name="notes" placeholder="Optional notes"></div>' }
    if (type === 'record-attendance') { title = 'Record Attendance'; body = field('event', 'Event', 'select', true, data.events.map(e => e.name)) + field('member', 'Member', 'select', true, data.members.map(m => m.name)) + field('status', 'Attendance status', 'select', true, ['Present', 'Absent', 'Late', 'Excused']) }
    fields.innerHTML = body; if (record) { Object.entries(record).forEach(([k, v]) => { const el = fields.querySelector(`[name="${k}"]`); if (el) el.value = v }) }
    if (type === 'add-event') { const d = fields.querySelector('[name="date"]'); if (d) d.value = addDays(1); fields.querySelector('[name="start"]').value = '09:00'; fields.querySelector('[name="end"]').value = '10:00' }
    if (type === 'add-availability') { fields.querySelector('[name="date"]').value = todayISO(); fields.querySelector('[name="from"]').value = '08:00'; fields.querySelector('[name="until"]').value = '17:00' }
    $('modalTitle').textContent = title; $('modalBackdrop').classList.add('show')
  }
  function closeModal() { $('modalBackdrop').classList.remove('show'); $('modalForm').reset(); modalType = null }
  $('modalClose').onclick = closeModal; $('modalCancel').onclick = closeModal; $('modalBackdrop').addEventListener('click', e => { if (e.target === $('modalBackdrop')) closeModal() });
  $('modalForm').addEventListener('submit', e => {
    e.preventDefault(); const f = Object.fromEntries(new FormData(e.target).entries());
    try {
      if (modalType === 'add-member' || modalType === 'edit-member') { if (!f.name.trim()) throw Error('Please enter a member name.'); if (modalType === 'edit-member') { const id = Number(e.target.dataset.editId), m = data.members.find(x => x.id === id); Object.assign(m, f) } else data.members.push({ id: Date.now(), ...f }); addNotice(`${modalType === 'edit-member' ? 'Member updated' : 'Member added'}: ${f.name}`); showPage('members') }
      if (modalType === 'add-event') { if (f.end <= f.start) throw Error('End time must be later than start time.'); const ev = { id: Date.now(), ...f, status: 'Pending' }; const conflicts = findConflicts(ev); data.events.push(ev); if (conflicts.length && data.preferences.conflicts) { addNotice(`Schedule conflict for ${ev.name}: ${conflicts.join('; ')}`); toast('Event saved, but a schedule conflict was detected.') } else addNotice(`Event created: ${ev.name}`); showPage('events') }
      if (modalType === 'add-availability') { if (f.until <= f.from) throw Error('Available-until must be later than available-from.'); data.availability.push({ id: Date.now(), ...f }); toast('Availability saved.'); showPage('schedules') }
      if (modalType === 'record-attendance') { data.attendance.push({ id: Date.now(), ...f, created: new Date().toLocaleString() }); if (data.preferences.attendance) addNotice(`Attendance recorded for ${f.member} — ${f.event}`); toast('Attendance recorded.'); showPage('attendance') }
      closeModal(); render(); if (!document.querySelector('.toast').textContent.includes('conflict')) toast('Changes saved successfully.');
    } catch (err) { toast(err.message) }
  });
  function findConflicts(candidate) { const conflicts = []; for (const e of data.events) { if (e.date === candidate.date && candidate.start < e.end && candidate.end > e.start) conflicts.push(`overlaps ${e.name}`) } for (const a of data.availability) { if (a.date === candidate.date && (candidate.start < a.from || candidate.end > a.until)) conflicts.push(`may be outside ${a.member}'s availability`) } return conflicts }
  document.addEventListener('click', e => {
    const edit = e.target.closest('[data-edit-member]'); if (edit) { const m = data.members.find(x => x.id === Number(edit.dataset.editMember)); openModal('edit-member', m); $('modalForm').dataset.editId = m.id; return }
    const delM = e.target.closest('[data-delete-member]'); if (delM && confirm('Remove this member?')) { const m = data.members.find(x => x.id === Number(delM.dataset.deleteMember)); data.members = data.members.filter(x => x.id !== m.id); data.availability = data.availability.filter(x => x.member !== m.name); data.attendance = data.attendance.filter(x => x.member !== m.name); addNotice(`Member removed: ${m.name}`); render(); toast('Member removed.') }
    const delE = e.target.closest('[data-delete-event]'); if (delE && confirm('Delete this event?')) { const ev = data.events.find(x => x.id === Number(delE.dataset.deleteEvent)); data.events = data.events.filter(x => x.id !== ev.id); data.attendance = data.attendance.filter(x => x.event !== ev.name); render(); toast('Event deleted.') }
    const check = e.target.closest('[data-check-event]'); if (check) { const ev = data.events.find(x => x.id === Number(check.dataset.checkEvent)), c = findConflicts(ev); alert(c.length ? 'Potential conflicts:\n• ' + c.join('\n• ') : 'No overlapping event or recorded availability conflicts found.') }
    const da = e.target.closest('[data-delete-attendance]'); if (da) { data.attendance = data.attendance.filter(x => x.id !== Number(da.dataset.deleteAttendance)); render(); toast('Attendance record removed.') }
    const dv = e.target.closest('[data-delete-availability]'); if (dv) { data.availability = data.availability.filter(x => x.id !== Number(dv.dataset.deleteAvailability)); render(); toast('Availability removed.') }
    const dn = e.target.closest('[data-delete-notice]'); if (dn) { data.notices = data.notices.filter(x => String(x.id) !== dn.dataset.deleteNotice); render() }
  });
  $('checkConflicts').onclick = () => { const all = []; data.events.forEach(e => findConflicts(e).forEach(c => all.push(`${e.name}: ${c}`))); $('conflictResults').textContent = all.length ? all.join(' • ') : 'No conflicts detected.'; if (all.length && data.preferences.conflicts) addNotice('Schedule conflict check found ' + all.length + ' potential issue(s).'); renderNotices() };
  $('generateReminders').onclick = () => { let n = 0; data.events.filter(e => e.date >= todayISO() && e.date <= addDays(7)).forEach(e => { addNotice(`Reminder: ${e.name} is scheduled on ${fmtDate(e.date)} at ${e.start}.`); n++ }); render(); toast(n ? `${n} reminder(s) generated.` : 'No events in the next 7 days.') };
  $('clearNotifications').onclick = () => { if (confirm('Clear all notifications?')) { data.notices = []; render(); toast('Notifications cleared.') } };
  $('settingsForm').addEventListener('submit', e => { e.preventDefault(); data.profile = { name: $('settingsName').value.trim(), role: $('settingsRole').value, org: $('settingsOrg').value.trim(), code: $('settingsCode').value.trim() }; addNotice('Organization profile settings updated.'); render(); toast('Settings saved.') });
  document.querySelectorAll('[data-toggle]').forEach(b => b.addEventListener('click', () => { const k = b.dataset.toggle; data.preferences[k] = !data.preferences[k]; b.classList.toggle('on', data.preferences[k]); save(); toast('Notification preference updated.') }));
  $('exportData').onclick = () => { const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' }), url = URL.createObjectURL(blob), a = document.createElement('a'); a.href = url; a.download = 'orgsync-data.json'; a.click(); URL.revokeObjectURL(url); toast('Data export downloaded.') };
  $('resetData').onclick = () => { if (confirm('Reset all OrgSync demo data? This cannot be undone.')) { data = structuredClone(defaultData); save(); render(); toast('Demo data reset.') } };
  render();

</script>