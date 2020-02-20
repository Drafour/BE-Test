# BE-Test
Back End Test

<h2>Response Status</h2>
<table>
  <thead>
    <tr>
      <th>Status</th>
      <th>Message</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>1</code></td>
      <td><code>Success.</code></td>
    </tr>
    <tr>
      <td><code>100</code></td>
      <td><code>Incomplete parameters.</code></td>
    </tr>
    <tr>
      <td><code>200</code></td>
      <td><code>Incorrect code.</code></td>
    </tr>
    <tr>
      <td><code>300</code></td>
      <td><code>Incorrect page.</code></td>
    </tr>
    <tr>
      <td><code>400</code></td>
      <td><code>Incorrect role.</code></td>
    </tr>
    <tr>
      <td><code>500</code></td>
      <td><code>User not found.</code></td>
    </tr>
    <tr>
      <td><code>600</code></td>
      <td><code>You don't have permission.</code></td>
    </tr>
    <tr>
      <td><code>700</code></td>
      <td><code>Username already exists.</code></td>
    </tr>
    <tr>
      <td><code>800</code></td>
      <td><code>Email already exists.</code></td>
    </tr>
  </tbody>
</table>

<h2>Add User</h2>
<p>URL:</p>
<pre>http://drafour.com/demo/be-test/api/add-user</pre>
<p>Parameters Definition:</p>
<table>
  <thead>
    <tr>
      <th>Fields</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>code</code></td>
      <td><code>User code that will add another user.</code></td>
    </tr>
    <tr>
      <td><code>username</code></td>
      <td><code>Username to be add.</code></td>
    </tr>
    <tr>
      <td><code>first_name</code></td>
      <td><code>First name to be add.</code></td>
    </tr>
    <tr>
      <td><code>last_name</code></td>
      <td><code>Last name to be add.</code></td>
    </tr>
    <tr>
      <td><code>email</code></td>
      <td><code>Email to be add.</code></td>
    </tr>
    <tr>
      <td><code>password</code></td>
      <td><code>Password to be add.</code></td>
    </tr>
    <tr>
      <td><code>phone</code></td>
      <td><code>Phone number to be add.</code></td>
    </tr>
    <tr>
      <td><code>role</code></td>
      <td><code>User role to be add. There are 2 roles: Admin and Member.</code></td>
    </tr>
  </tbody>
</table>

<h2>Edit User</h2>
<p>URL:</p>
<pre>http://drafour.com/demo/be-test/api/edit-user</pre>
<p>Parameters Definition:</p>
<table>
  <thead>
    <tr>
      <th>Fields</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>code</code></td>
      <td><code>User code that will change another user.</code></td>
    </tr>
    <tr>
      <td><code>id</code></td>
      <td><code>Decide which users will be changed.</code></td>
    </tr>
    <tr>
      <td><code>first_name</code></td>
      <td><code>First name to be changed.</code></td>
    </tr>
    <tr>
      <td><code>last_name</code></td>
      <td><code>Last name to be changed.</code></td>
    </tr>
    <tr>
      <td><code>email</code></td>
      <td><code>Email to be changed.</code></td>
    </tr>
    <tr>
      <td><code>password</code></td>
      <td><code>Password to be changed.</code></td>
    </tr>
    <tr>
      <td><code>phone</code></td>
      <td><code>Phone number to be changed.</code></td>
    </tr>
    <tr>
      <td><code>role</code></td>
      <td><code>User role to be changed. There are 2 roles: Admin and Member.</code></td>
    </tr>
  </tbody>
</table>

<h2>Delete User</h2>
<p>URL:</p>
<pre>http://drafour.com/demo/be-test/api/delete-user</pre>
<p>Parameters Definition:</p>
<table>
  <thead>
    <tr>
      <th>Fields</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>code</code></td>
      <td><code>User code that will change another user.</code></td>
    </tr>
    <tr>
      <td><code>id</code></td>
      <td><code>Decide which users will be deleted.</code></td>
    </tr>
  </tbody>
</table>

<h2>Get User</h2>
<p>URL:</p>
<pre>http://drafour.com/demo/be-test/api/get-user</pre>
<p>Parameters Definition:</p>
<table>
  <thead>
    <tr>
      <th>Fields</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>code</code></td>
      <td><code>User code that will get user.</code></td>
    </tr>
    <tr>
      <td><code>username</code></td>
      <td><code>Username to be searched for.</code></td>
    </tr>
  </tbody>
</table>

<h2>Get User List</h2>
<p>URL:</p>
<pre>http://drafour.com/demo/be-test/api/get-user-list</pre>
<p>Parameters Definition:</p>
<table>
  <thead>
    <tr>
      <th>Fields</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>code</code></td>
      <td><code>User code that will get user list.</code></td>
    </tr>
    <tr>
      <td><code>page</code></td>
      <td><code>Page to be displayed. Minimum number is 1.</code></td>
    </tr>
  </tbody>
</table>
